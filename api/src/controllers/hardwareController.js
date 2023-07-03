import { prismaClient } from '../app/database.js';

const getHardware = async (req, res) => {
  const hardware_id = parseInt(req.params.id);

  const check = await prismaClient.hardware.findUnique({
    where: {
      id: hardware_id,
    },
    select: {
      name: true,
      state: true,
    },
  });

  if (!check) {
    return res.status(404).json({
      error: 'Hardware not found',
      name: 'Hardware not found',
      state: false,
    });
  }

  res.status(200).json(check);
};

export default getHardware;
