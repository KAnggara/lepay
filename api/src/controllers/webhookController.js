import 'dotenv/config';
import { logger } from '../app/logging.js';
import { prismaClient } from '../app/database.js';
import { apiRequest } from '../services/services.js';

const webhookIncomingMessage = async (req, res) => {
  const body = req.body;
  const payload = body.payload;

  const text = payload.text;
  const sender = payload.sender;
  const device_id = payload.device_id;
  const message_type = payload.message_type;
  const webhook_type = body.webhook_type;

  if (webhook_type === 'incoming_message') {
    const check = await prismaClient.message.findFirst({
      where: {
        trigger: text,
      },
      select: {
        state: true,
        response: true,
        hardwareId: true,
      },
    });

    if (check === null) {
      res.status(204).end();
    } else {
      const data = {
        phone_number: sender,
        message: check.response,
        device_id: device_id,
        message_type: message_type,
      };
      if (check.hardwareId && check.state) {
        await prismaClient.hardware.update({
          where: {
            id: check.hardwareId,
          },
          data: {
            state: check.state,
          },
        });
      }
      const url = new URL(process.env.API_SERVER + '/messages');
      const reqParams = {
        token: process.env.API_TOKEN,
        url: url,
        method: 'POST',
        payload: JSON.stringify(data),
      };

      try {
        const { body, response } = await apiRequest(reqParams);
        res.status(response.statusCode).json(JSON.parse(body));
      } catch (error) {
        res.status(error.response.statusCode).json(JSON.parse(error.body));
      }
    }
  } else {
    logger.error({ message: 'Unknown webhook type of ' + webhook_type });
    res.status(400).end();
  }
};

export { webhookIncomingMessage };
