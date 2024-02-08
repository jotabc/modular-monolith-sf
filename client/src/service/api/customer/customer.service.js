import { apiClient } from '../apiClient'

const routes = {
  base: '/employees',
}

export const searchCustomers = async (id, filters) => {
  return apiClient.get(`${ routes.base }/${ id }/customers${ filters }`)
}
