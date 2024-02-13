import { useEffect, useState } from 'react'
import {
  Flex,
  Heading,
  Input,
  Button,
  InputGroup,
  Stack,
  InputLeftElement,
  chakra,
  Box,
  Avatar,
  FormControl,
  InputRightElement,
  Text,
  useToast,
  useColorMode,
} from '@chakra-ui/react'
import { FaUserAlt, FaLock } from 'react-icons/fa'
import { Controller, useForm } from 'react-hook-form'
import * as yup from 'yup'
import { yupResolver } from '@hookform/resolvers/yup'
import { decodeToken, login } from '../src/service/api/auth/auth.service'
import { useRouter } from 'next/router'
import {useDispatch, useSelector} from 'react-redux'
import {saveUser} from '../src/redux/reducer/auth'

const CFaUserAlt = chakra(FaUserAlt)
const CFaLock = chakra(FaLock)

export default function Home() {
  const router = useRouter()
  const dispatch = useDispatch()
  const token = useSelector( state => state.auth.token )

  const { colorMode, toggleColorMode } = useColorMode()
  const toast = useToast()

  const validationSchema = yup.object().shape({
    email: yup.string().email('Invalid email').required('Email is mandatory'),
    password: yup
      .string()
      .required('Password is mandatory')
      .min(6, 'Password must be at least 6 characters'),
  })

  const {
    control,
    handleSubmit,
    formState: { errors },
  } = useForm({ resolver: yupResolver(validationSchema) })

  const onSubmitForm = async (data) => {
    try {
      const response = await login(data.email.trim(), data.password.trim())
      const token = response.data.token
      const payload = decodeToken(token)

      dispatch(saveUser(token, payload))

      await router.push('/dashboard')
    } catch (e) {
      toast({
        title: 'Invalid credentials',
        description: "Invalid email or password. Please try again!",
        status: 'error',
        duration: 5000,
        isClosable: true,
      })
    }
  }

  const [showPassword, setShowPassword] = useState(false)

  const handleShowClick = () => setShowPassword(!showPassword)

  useEffect( () => {
    async function toDashboard() {
      router.push('/dashboard')
    }

    if (undefined !== token) {
      toDashboard()
    }
  }, [])

  useEffect(() => {
    if ('dark' === colorMode) {
      toggleColorMode()
    }
  })

  return (
    <Flex
      flexDirection="column"
      width="100wh"
      height="100vh"
      backgroundColor="gray.200"
      justifyContent="center"
      alignItems="center"
    >
      <Stack
        flexDir="column"
        mb="2"
        justifyContent="center"
        alignItems="center"
      >
        <Avatar bg="teal.500" />
        <Heading color="teal.400">Car - Rental</Heading>
        <Box minW={{ base: '90%', md: '468px' }}>
          <form onSubmit={handleSubmit(onSubmitForm)}>
            <Stack
              spacing={4}
              p="1rem"
              backgroundColor="whiteAlpha.900"
              boxShadow="md"
            >
              <FormControl>
                <InputGroup>
                  <InputLeftElement pointerEvents="none">
                    <CFaUserAlt color="gray.300" />
                  </InputLeftElement>
                  <Controller
                    control={control}
                    name="email"
                    render={({ field: { onChange, value, ref } }) => (
                      <Input
                        type="email"
                        placeholder="Email address"
                        onChange={onChange}
                        value={value}
                        ref={ref}
                      />
                    )}
                  />
                </InputGroup>
                <Text fontSize="sm" color="red.500">
                  {errors?.email?.message}
                </Text>
              </FormControl>

              <FormControl>
                <InputGroup>
                  <InputLeftElement pointerEvents="none" color="gray.300">
                    <CFaLock color="gray.300" />
                  </InputLeftElement>

                  <Controller
                    control={control}
                    name="password"
                    render={({ field: { onChange, value, ref } }) => (
                      <Input
                        type={showPassword ? 'text' : 'password'}
                        placeholder="Password"
                        onChange={onChange}
                        value={value}
                        ref={ref}
                      />
                    )}
                  />

                  <InputRightElement width="4.5rem">
                    <Button h="1.75rem" size="sm" onClick={handleShowClick}>
                      {showPassword ? 'Hide' : 'Show'}
                    </Button>
                  </InputRightElement>
                </InputGroup>
                <Text fontSize="sm" color="red.500">
                  {errors?.password?.message}
                </Text>
              </FormControl>

              <Button
                borderRadius={0}
                type="submit"
                variant="solid"
                colorScheme="teal"
                width="full"
              >
                Login
              </Button>
            </Stack>
          </form>
        </Box>
      </Stack>
    </Flex>
  )
}
