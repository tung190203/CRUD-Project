import axiosInstance from "@/utils/httpRequest.js";
import {API_ENDPOINT} from "@/constants/index.js";

const endpoint = API_ENDPOINT.AUTH;

export const login = async (data) => {
  return axiosInstance.post(`${endpoint}/login`, data).then((response) => response.data);
};

export const register = async (data) => {
  const {confirmPassword, ...postData} = data;
  postData.password_confirmation = confirmPassword;
  return axiosInstance.post(`${endpoint}/register`, postData).then((response) => response.data);
};

export const logout = async () => {
  return axiosInstance.post(`${endpoint}/logout`).then((response) => response.data);
};