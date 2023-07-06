/* eslint-disable no-console */
import express from 'express';
import {
  addDevices,
  getDevices,
  getAllDevices,
  deleteDevices,
} from '../controllers/devicesController.js';
import getQRCode from '../controllers/qrController.js';
import getHardware from '../controllers/hardwareController.js';
import webhookMessages from '../controllers/webhookController.js';

const publicRouter = new express.Router();

publicRouter.get('/', (req, res) => {
  res.status(301).redirect('https://wahyuda.my.id');
});

publicRouter.get('/qr', getQRCode);
publicRouter.get('/devices', getAllDevices);
publicRouter.get('/hardware/:id', getHardware);
publicRouter.get('/devices/:device_id', getDevices);
publicRouter.post('/devices', addDevices);
publicRouter.post('/webhook', webhookMessages);
publicRouter.delete('/devices/:device_id', deleteDevices);

publicRouter.get('*', function (req, res) {
  res.status(404).send('what???');
});

publicRouter.post('*', function (req, res) {
  res.status(404).send('what???');
});

export { publicRouter };
