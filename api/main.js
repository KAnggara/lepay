/* eslint-disable no-console */

import QRCode from 'qrcode'
import wajs from 'whatsapp-web.js'
const { Client, LocalAuth } = wajs

const client = new Client({
  authStrategy: new LocalAuth(),
})

client.on('qr', (qr) => {
  QRCode.toString(qr, { type: 'terminal', small: true }, (err, qr) => {
    try {
      console.info('QR Code received')
      console.info(qr)
    } catch (err) {
      console.error(err)
    }
  })
})

client.on('ready', () => {
  console.log('Client is ready!')
})

client.on('message', (message) => {
  let pesan = message.body.toLowerCase()
  console.log('Pesan masuk: ' + pesan)
  if (pesan === 'test') {
    for (let i = 0; i < 10; i++) {
      message.reply('Test ke-' + i + ' Berhasil')
    }
  }
})

client.initialize()
