/* eslint-disable no-console */
import { PrismaClient } from '@prisma/client';
import { messages } from './messageSeeder.js';
import { hardwares } from './hardwareSeeder.js';
const prisma = new PrismaClient();

const load = async () => {
  const tableNames = ['hardwares', 'users', 'messages', 'devices'];

  try {
    for (const tableName of tableNames) {
      await prisma.$queryRawUnsafe(`SET FOREIGN_KEY_CHECKS = 0;`);
      await prisma.$queryRawUnsafe(`TRUNCATE TABLE ${tableName};`);
      await prisma.$queryRawUnsafe(`SET FOREIGN_KEY_CHECKS = 1;`);
    }

    await prisma.hardware.createMany({
      data: hardwares,
    });
    console.log('Added category data');

    await prisma.message.createMany({
      data: messages,
    });
    console.log('Added product data');
  } catch (e) {
    console.error(e);
    process.exit(1);
  } finally {
    await prisma.$disconnect();
  }
};

load();
