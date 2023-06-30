/* eslint-disable no-console */
import 'dotenv/config';
import { apiRequest } from '../services/services.js';

const getQRCode = async (req, res) => {
  const device_id = req.query.device_id;

  const url = new URL(process.env.API_SERVER + '/qr?device_id=' + device_id);

  const reqParams = {
    token: process.env.API_TOKEN,
    url: url,
  };

  try {
    const { body, response } = await apiRequest(reqParams);
    console.log(body);
    res.status(response.statusCode).json(JSON.parse(body));
  } catch (error) {
    //   console.error('Something went wrong', {
    //     body: error,
    //     statusCode: error.response.statusCode,
    //   });
    res.status(error.response.statusCode).json(JSON.parse(error.body));
  }
};

export default getQRCode;
