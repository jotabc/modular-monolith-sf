import { jwtDecode } from 'jwt-decode'
import { apiClient } from '../apiClient'

const routes = {
  login: 'login_check',
}

export const login = async (username, password) => {
  return await apiClient.post(routes.login, { username, password })
}

export const decodeToken = (token) => {
  try {
    return jwtDecode(token)
  } catch (e) {
    console.log(e)
  }
}
