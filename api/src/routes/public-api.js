/* eslint-disable no-console */
import express from 'express';
import {
  addDevices,
  getDevices,
  getAllDevices,
  deleteDevices,
} from '../controllers/devicesController.js';

import { webhookIncomingMessage } from '../controllers/webhookController.js';
const publicRouter = new express.Router();

publicRouter.post('/devices', addDevices);
publicRouter.get('/devices', getAllDevices);
publicRouter.get('/devices/:device_id', getDevices);
publicRouter.delete('/devices/:device_id', deleteDevices);
publicRouter.post('/webhook', webhookIncomingMessage);

export { publicRouter };