import https from 'https';

/**
 * Make request to API
 * @param Object params
 * @return Promise
 */
function apiRequest(params) {
  return new Promise((resolve, reject) => {
    let payloadBuffer;
    let responseBody = '';
    const options = {
      method: params.method || 'GET',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${params.token}`,
      },
    };

    if (params.method === 'POST') {
      payloadBuffer = Buffer.from(params.payload);
      options.headers['Content-Length'] = payloadBuffer.length;
    }

    const req = https.request(params.url, options, function (res) {
      res.on('data', function concatBody(chunk) {
        responseBody += chunk;
      });

      res.on('end', () => {
        if (res.statusCode >= 200 && res.statusCode < 300) {
          resolve({ body: responseBody, response: res });
          return;
        }

        // Non 2XX response
        reject({ body: responseBody, response: res });
      });
    });

    if (params.method === 'POST') {
      req.write(payloadBuffer);
    }

    req.end();
  }); // Promise
}

export { apiRequest };
