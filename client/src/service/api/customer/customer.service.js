import { apiClient } from '../apiClient'

const routes = {
  base: 'employees',
}

export const searchCustomers = async (id, filters) => {
  return apiClient.get(`${ routes.base }/${ id }/customers${ filters }`)
}

export const createCustomer = async (employeeId, payload) => {
  const response = await apiClient.post(`${routes.base}/${employeeId}/customers`, payload)
  return response.data
}
