import axios from 'axios'

const BASE_URL = process.env.NEXT_PUBLIC_API_BASE_URL
const API_PATH = process.env.NEXT_PUBLIC_API_PATH

export const axiosClient = axios.create({
  baseURL: BASE_URL,
  timeout: 1000,
  headers: {
    // 'Authorization': `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MDc1MTQ5NzQsImV4cCI6MTcwODgxMDk3NCwicm9sZXMiOltdLCJ1c2VybmFtZSI6ImFkbWluQGFwaS5jb20iLCJpZCI6IjI2NTQxYmUyLWU1NWQtNGEwNi1hY2Q1LWNmYWVjMGQ4OTYyZCJ9.SONwtsHo6RSUwP-j7xLKbn5RFAF-vb0cd6Bp67RXnm6JcpZ4fHipQIi7jxwH6QfYWt6keHS7EqjhHjP1DJe4UZIjmQrk8swaf6g38HhxXGpylwqvIGm4-yj5dBMNNOljTpQg0yk_iLlbnBjX8epM-Zl9bCl7yRM7RruL1M7SDG4FEL7WaOE5OdQYk2Oa9HDNG_37Rl07LLsvFSDhSEs8m0bRLIQoq800JOieQtT9ZaCB5tlpfGHeTHzyW3aPNW7vhvcQPalRgh25dik7uMxet20N9yEihEXkeufll4h-djf1l8789Upc6VW4qihkikJLLZiCbR_8ACHnvrXUnJU5lg`,
  },
})

export const apiClient = {
  get: async (path, config) => {
    return axiosClient.get(`${ API_PATH }/${ path }`, config)
  },

  post: async (path, payload, config = {}) => {
    return axiosClient.post(`${ API_PATH }/${ path }`, payload, config)
  },

  put: async (path, payload, config = {}) => {
    return axiosClient.put(`${ API_PATH }/${ path }`, payload, config)
  },

  remove: async (path) => {
    return axiosClient.delete(`${ API_PATH }/${ path }`)
  },
}
