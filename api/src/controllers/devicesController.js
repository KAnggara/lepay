/* eslint-disable no-console */
import 'dotenv/config';
import { apiRequest } from '../services/services.js';

const getAllDevices = async (req, res) => {
  const url = new URL(process.env.API_SERVER + '/devices');
  const reqParams = {
    token: process.env.API_TOKEN,
    url: url,
  };
  try {
    const { body, response } = await apiRequest(reqParams);
    console.log(body);
    res.status(response.statusCode).json(JSON.parse(body));
  } catch (error) {
    console.error('Something went wrong', {
      body: error,
      statusCode: error.response.statusCode,
    });
    res.status(error.response.statusCode).json(JSON.parse(error.body));
  }
};

const getDevices = async (req, res) => {
  const device_id = req.params.device_id;
  const url = new URL(process.env.API_SERVER + '/devices/' + device_id);

  const reqParams = {
    token: process.env.API_TOKEN,
    url: url,
  };
  try {
    const { body, response } = await apiRequest(reqParams);
    res.status(response.statusCode).json(JSON.parse(body));
  } catch (error) {
    res.status(error.response.statusCode).json(JSON.parse(error.body));
  }
};

const deleteDevices = async (req, res) => {
  const device_id = req.params.device_id;
  const url = new URL(process.env.API_SERVER + '/devices/' + device_id);

  const reqParams = {
    token: process.env.API_TOKEN,
    url: url,
    method: 'DELETE',
  };

  try {
    const { response } = await apiRequest(reqParams);
    console.log(device_id + ' Deleted');
    res.status(response.statusCode).end();
  } catch (error) {
    console.error('Something went wrong', {
      body: error.body,
      statusCode: error.response.statusCode,
    });
    res.status(error.response.statusCode).json(JSON.parse(error.body));
  }
};

const addDevices = async (req, res) => {
  const device_id = req.body.device_id;
  const url = new URL(process.env.API_SERVER + '/devices');

  const reqParams = {
    token: process.env.API_TOKEN,
    url: url,
    method: 'POST',
    payload: JSON.stringify({
      device_id: device_id,
    }),
  };

  try {
    const { body, response } = await apiRequest(reqParams);
    console.log(body);
    res.status(response.statusCode).json(JSON.parse(body));
  } catch (error) {
    console.error('Something went wrong', {
      body: error.body,
      statusCode: error.response.statusCode,
    });
    res.status(error.response.statusCode).json(JSON.parse(error.body));
  }
};

export { addDevices, getAllDevices, getDevices, deleteDevices };
