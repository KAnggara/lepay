/* eslint-disable no-console */
import { apiRequest } from '../services/services.js';

const sendMessage = async (req, res) => {
  const body = req.body;

  const text = body.message;
  const receiver = body.phone_number;
  const device_id = body.device_id;
  const message_type = body.message_type;
  const url = new URL(process.env.API_SERVER + '/messages');

  const message = {
    message: text,
    phone_number: receiver,
    message_type: message_type,
    device_id: device_id,
  };

  const reqParams = {
    token: process.env.API_TOKEN,
    url: url,
    method: 'POST',
    payload: JSON.stringify(message),
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

export default sendMessage;
