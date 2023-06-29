import { web } from './app/web.js';
import { logger } from './app/logging.js';

web.listen(3000, () => {
  logger.info('Listening on port 3000');
});
