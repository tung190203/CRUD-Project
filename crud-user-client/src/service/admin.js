import axiosInstance from "@/utils/httpRequest.js";
import {API_ENDPOINT} from "@/constants/index.js";

const endpoint = API_ENDPOINT.ADMIN;

export const getAllUsers = async () => {
  return axiosInstance.get(`${endpoint}/users`).then((response) => response.data);
};

export const createUser = async (data) => {
  return axiosInstance.post(`${endpoint}/create`, data).then((response) => response.data);
};

export const updateUser = async (data) => {
  const {id,...postData} = data;
  return axiosInstance.post(`${endpoint}/update/${id}`, postData).then((response) => response.data);
};

export const deleteUser = async (id) => {
  return axiosInstance.delete(`${endpoint}/delete/${id}`).then((response) => response.data);
};