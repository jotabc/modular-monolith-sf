import { Button, Col, Container, Form, Row } from 'react-bootstrap'
import { Controller, useForm } from 'react-hook-form'
import * as yup from 'yup'
import { yupResolver } from '@hookform/resolvers/yup'

export default function Home() {
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
    console.log(data)
    // TODO api call to Google OAuth
  }

  return (
    <Container className={'mt-5'} fluid>
      <Row className={'justify-content-center'}>
        <Col md={4}>
          <h1 className={'mb-3'}>
            <Form onSubmit={handleSubmit(onSubmitForm)}>
              <Form.Group className="mb-3" controlId="formBasicEmail">
                <Form.Label>Email address</Form.Label>
                <Controller
                  control={control}
                  name="email"
                  render={({ field: { onChange, value, ref } }) => (
                    <Form.Control
                      onChange={onChange}
                      value={value}
                      ref={ref}
                      placeholder="Enter email"
                      type="email"
                      isValid={errors.email}
                    />
                  )}
                />
                <Form.Text className="text-danger">
                  {errors.email?.message}
                </Form.Text>
              </Form.Group>

              <Form.Group className="mb-3" controlId="formBasicPassword">
                <Form.Label>Password</Form.Label>
                <Controller
                  control={control}
                  name="password"
                  render={({ field: { onChange, value, ref } }) => (
                    <Form.Control
                      onChange={onChange}
                      value={value}
                      ref={ref}
                      placeholder="Password"
                      isValid={errors.password}
                      type="password"
                    />
                  )}
                />
                <Form.Text className="text-danger">
                  {errors.password?.message}
                </Form.Text>
              </Form.Group>

              <Button variant="primary" type="submit">
                Login
              </Button>
            </Form>
          </h1>
        </Col>
      </Row>
    </Container>
  )
}
