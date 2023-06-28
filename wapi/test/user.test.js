import supertest from 'supertest'
import { web } from '../src/app/web.js'
import { prismaClient } from '../src/app/database.js'

describe('POST /api/users', function () {
  afterEach(async () => {
    await prismaClient.user.deleteMany({
      where: {
        username: 'John Doe',
      },
    })
  })

  it('should return 201 Created', async () => {
    const result = await supertest(web).post('/api/users').send({
      username: 'John Doe',
      email: 'aajdknkasj@baudishas.com',
      password: '123456',
    })

    expect(result.status).toBe(201)
    expect(result.body.data.username).toBe('John Doe')
    expect(result.body.data.email).toBe('aajdknkasj@baudishas.com')
    expect(result.body.data.password).toBeUndefined()
  })
})
