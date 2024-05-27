import axios from "axios";
import {LOCAL_STORAGE_KEY} from "@/constants/index.js";

const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_BASE_URL,
});

axiosInstance.interceptors.request.use(function (config) {
  const token = localStorage.getItem(LOCAL_STORAGE_KEY.LOGIN_TOKEN);
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, function (error) {
  return Promise.reject(error);
});

axiosInstance.interceptors.response.use(function (response) {
  return response;
}, function (error) {
  return Promise.reject(error);
});

export const get = async (url) => {
  return axiosInstance.get(url);
}

export const post = async (url, data) => {
  return axiosInstance.post(url, data);
}

export default axiosInstance;