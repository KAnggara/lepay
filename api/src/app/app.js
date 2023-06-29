import express from 'express';
import { publicRouter } from '../routes/public-api.js';

export const web = express();
web.use(express.json());
web.use(publicRouter);
