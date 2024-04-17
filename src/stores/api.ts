import router from "@/router"
import axios from "axios"
import { useToast } from 'vue-toast-notification';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    "Content-type": "application/json",
    Accept: "application/json",
  },
})

api.interceptors.request.use(request => {
  // console.log("Starting Request", request)
  return request
})

api.interceptors.response.use(
  response => {
    // console.log("Response:", response)
  
    if (response.data.message) {
      if(response.status == 200){
        useToast().success(response.data.message);
      }else if(response.status == 201){
        useToast().success(response.data.message);
      }else if(response.status == 204){
        useToast().warning(response.data.message);
      }
    }
    return response
  },
  error => {
    if (error.response.data.message.search('SQLSTATE') == -1) {
      useToast().error(error.response.data.message);
    }
    else{
      useToast().error('An error occurred');
    }

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
