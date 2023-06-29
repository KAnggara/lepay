/* eslint-disable no-console */
import { web } from './app/app.js';

web.listen(3000, () => {
  // logger.info('Listening on port 3000');
  console.info('Listening on port 3000');
});
