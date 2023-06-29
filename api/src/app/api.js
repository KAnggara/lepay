/* eslint-disable no-console */
import 'dotenv/config';
import express from 'express';
import { apiRequest } from './services.js';

const app = express();
app.use(express.json());

app.get('/qr', function (req, res) {
  const device_id = req.query.device_id;
  res.send('device_id: ' + device_id);
  console.log('device_id: ' + device_id);
  const ram = process.memoryUsage().heapUsed / 1024 / 1024;
  const rss = process.memoryUsage().rss / 1024 / 1024;
  console.info('Ram used: ' + Math.round(ram * 100) / 100 + ' MB');
  console.info('Rss used: ' + Math.round(rss * 100) / 100 + ' MB');
});

app.get('/devices', async (req, res) => {
  const url = new URL(process.env.API_SERVER + '/devices');
  const reqParams = {
    token: process.env.API_TOKEN,
    url: url,
  };
  try {
    const { body } = await apiRequest(reqParams);
    console.info(JSON.parse(body));
    res.json(JSON.parse(body));
  } catch (error) {
    console.error('Something went wrong', {
      body: error,
      // statusCode: error.response.statusCode,
    });
  }

  const ram = process.memoryUsage().heapUsed / 1024 / 1024;
  const rss = process.memoryUsage().rss / 1024 / 1024;
  console.info('Ram used: ' + Math.round(ram * 100) / 100 + ' MB');
  console.info('Rss used: ' + Math.round(rss * 100) / 100 + ' MB');
});

app.listen(3000, () => {
  console.info('Listening on port 3000');
});

// Lihat apiKirimWaRequest() pada Contoh Integrasi diatas
