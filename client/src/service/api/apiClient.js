import axios from 'axios'

const FULL_API_PATH = `${process.env.NEXT_PUBLIC_API_BASE_URL}/${process.env.NEXT_PUBLIC_API_PATH}`

const axiosClient = axios.create({
  baseURL: FULL_API_PATH,
  timeout: 1000,
  headers: {
    // 'Authorization': `Bearer`,
  },
})

export const apiClient = {
  get: async (path, config) => {
    return axiosClient.get(path, config)
  },

  post: async (path, payload, config = {}) => {
    return axiosClient.post(path, payload, config)
  },

  put: async (path, payload, config = {}) => {
    return axiosClient.put(path, payload, config)
  },

  remove: async (path) => {
    return axiosClient.delete(path)
  },
}
