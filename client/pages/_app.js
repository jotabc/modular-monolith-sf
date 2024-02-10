import { ChakraProvider } from '@chakra-ui/react'
import { combineReducers, legacy_createStore as createStore } from 'redux'
import AuthReducer, { fromLocalStorage } from '../src/redux/reducer/auth'
import { loadState, saveState } from '../src/service/storage/storage.service'
import throttle from 'lodash/throttle'
import { createWrapper } from 'next-redux-wrapper'
import { Provider, useSelector } from 'react-redux'
import { axiosClient } from '../src/service/api/apiClient'

const rootReducer = combineReducers({
  auth: AuthReducer,
})

const store = createStore(rootReducer)
const makeStore = () => store
const wrapper = createWrapper(makeStore)

loadState()
  .then((state) => {
    undefined !== state && store.dispatch(fromLocalStorage(state.auth))
  })
  .catch((err) => console.error(err))

store.subscribe(
  throttle(() => {
    saveState({
      auth: store.getState().auth,
    })
  }, 1000),
)

function MyApp({ Component, pageProps }) {
  const token = useSelector((state) => state.auth.token)
  axiosClient.defaults.headers.Authorization = `Bearer ${token}`

  return (
    <ChakraProvider>
      <Provider store={store}>
        <Component {...pageProps} />
      </Provider>
    </ChakraProvider>
  )
}

export default wrapper.withRedux(MyApp)
