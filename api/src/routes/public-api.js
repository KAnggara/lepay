/* eslint-disable no-console */
import express from 'express';
import {
  addDevices,
  getDevices,
  getAllDevices,
  deleteDevices,
} from '../controllers/devicesController.js';

const publicRouter = new express.Router();

publicRouter.post('/devices', addDevices);
publicRouter.get('/devices', getAllDevices);
publicRouter.get('/devices/:device_id', getDevices);
publicRouter.delete('/devices/:device_id', deleteDevices);

export { publicRouter };
