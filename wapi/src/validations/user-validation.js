import Joi from 'joi'

const registerUserValidation = Joi.object({
  username: Joi.string().min(6).max(250).required(),
  password: Joi.string().min(6).max(250).required(),
  email: Joi.string().email().required(),
})

export { registerUserValidation }
