/* eslint-disable no-console */

import QRCode from 'qrcode';
import wajs from 'whatsapp-web.js';
const { Client, LocalAuth } = wajs;

const client = new Client({
  authStrategy: new LocalAuth(),
});

client.on('qr', (qr) => {
  QRCode.toString(qr, { type: 'terminal', small: true }, (err, qr) => {
    try {
      console.info('QR Code received');
      console.info(qr);
    } catch (err) {
      console.error(err);
    }
  });
});

client.on('ready', () => {
  const number = '6282213433091';
  const text = 'Halo, Bot is Ready';
  const chatId = number + '@c.us';
  client.sendMessage(chatId, text);
  console.log('Client is ready!');
});

client.on('message', async (msg) => {
  let message = msg.body.toLowerCase();
  const contact = await msg.getContact();
  const name = contact.pushname;

  if (!msg.isStatus) {
    console.log('Pesan masuk: "' + message + '" Dari ' + name);
  }

  if (message === 'halo' || message === 'hai' || message === 'hi') {
    msg.reply(message);
  }

  if (message === 'on' || message === 'hidupkan' || message === 'nyalakan') {
    msg.reply('Lampu di nyalakan');
  }

  if (message === 'off' || message === 'matikan' || message === 'padamkan') {
    msg.reply('Lampu di matikan');
  }

  if (!msg.fromMe) {
    const number = '6282213433091';
    const chatId = number + '@c.us';
    client.sendMessage(chatId, message);
  }
});

client.initialize();
