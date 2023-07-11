import 'dotenv/config';
import { logger } from '../app/logging.js';
import { prismaClient } from '../app/database.js';
import { apiRequest } from '../services/services.js';

const webhookMessages = async (req, res) => {
  const body = req.body;
  const payload = body.payload;

  const text = payload.text;
  const sender = payload.sender;
  const device_id = payload.device_id;
  const timestamp = payload.timestamp;
  const webhook_type = body.webhook_type;
  const message_type = payload.message_type;

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

      await prismaClient.log.create({
        data: {
          text: text,
          sender: sender,
          time: timestamp,
          device_id: device_id,
        },
      });

      if (check.hardwareId != null && check.state != null) {
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
  } else if (webhook_type === 'send_message_response') {
    res.status(200).end();
  } else if (webhook_type === 'device_status_changed') {
    res.status(200).end();
  } else {
    logger.error({ message: 'Unknown webhook type of ' + webhook_type });
    res.status(400).end();
  }
};

export default webhookMessages;
