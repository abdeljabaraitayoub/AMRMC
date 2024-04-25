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
    console.log('Response:', response.headers)
    if(response.headers.token){
      console.log('token:', response.headers)
      localStorage.setItem('token', response.headers.token);
      alert(response.headers.token)
      // localStorage.setItem('token', response.headers.authorization);
    }
    return response
  },
  error => {
  
    if (error.response.status === 422) {
      useToast().error(error.response.data.message);
    }else if(error.response.status === 404){
      useToast().error('Resource not found');
    }
    else if(error.response.status === 500){
      useToast().error('Server error');
    }
    else if(error.response.status === 401){
      // useToast().error('Unauthorized');
      // localStorage.removeItem('token');
      router.push('/signin');
    }
    else if(error.response.status === 403){
      
      useToast().error('Forbidden');
    }
    else{
      useToast().error('An error occurred');
    }
   
    return Promise.reject(error)
  },
)

api.interceptors.request.use(
  config => {

    // config.headers.Authorization ="Bearer " +import.meta.env.VITE_JWT_TOKEN
    // config.headers.Authorization ="Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMC4wLjAuMC9hcGkvbG9naW4iLCJpYXQiOjE3MTM2MTk4NzIsIm5iZiI6MTcxMzYxOTg3MiwiZXhwIjoxNzEzNjI3MiwianRpIjoiMlBpNndzYXNzc2Fzd3NnMHNhRlZWb09SM0hCaSIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.X6OTHn1SJ6MA-rP2DdJtw2bskQBNV1sUE8Kp6fQJP_8"
    if (localStorage.getItem("token")) {
      config.headers.Authorization = `Bearer ${localStorage.getItem("token")}`
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
