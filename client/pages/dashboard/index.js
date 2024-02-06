import {Button, Heading} from '@chakra-ui/react'
import {apiClient} from '../../src/service/api/apiClient'

export default function Dashboard() {

  const handleHealthCheck = () => {
    apiClient.get('customers/health-check', {})
      .then(r => console.log(r.data))
      .catch( e => console.error({ e }))
  }

  return (
    <>
      <Heading>Welcome to the Dashboard</Heading>
      <Button onClick={() => handleHealthCheck()}>Health check controller</Button>
    </>
  )
}
