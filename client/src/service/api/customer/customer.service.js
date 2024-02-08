import { apiClient } from '../apiClient'

const routes = {
  base: 'customers',
}

export const searchCustomers = async (filters) => {
  return apiClient.get(`${ routes.base }${ filters }`)
}
