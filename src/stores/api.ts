import router from "@/router"
import axios from "axios"

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    "Content-type": "application/json",
    Accept: "application/json",
  },
})

api.interceptors.request.use(request => {
  console.log("Starting Request", request)
  return request
})

api.interceptors.response.use(
  response => {
    console.log("Response:", response)
    return response
  },
  error => {
    if (error.response.status === 401 || error.response.status === 403) {
      router.push("/login")
    }
    return Promise.reject(error)
  },
)

api.interceptors.request.use(
  config => {

    config.headers.Authorization ="Bearer " +import.meta.env.VITE_JWT_TOKEN
    if (localStorage.getItem("token")) {
    //  console.log('Token:', localStorage.getItem('token'))
      // config.headers.Authorization = `${localStorage.getItem("token")}`
    }
    return config
  },
  error => {
    // Handle request errors
    return Promise.reject(error)
  },
)
export default api
