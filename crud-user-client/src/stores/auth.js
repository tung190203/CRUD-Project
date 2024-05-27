import {defineStore} from "pinia";
import {LOCAL_STORAGE_KEY, LOCAL_STORAGE_USER} from "@/constants/index.js";
import * as AuthService from "@/service/auth.js";
import * as AdminService from "@/service/admin.js";
import {computed, reactive, ref, watch} from "vue";

export const useUserStore = defineStore("user", () => {
  const user = reactive({
    id: null,
    name: "",
    email: "",
    role: "",
  })

  const ListUsers = ref([]);

  const getListUsers = computed(() => ListUsers.value)

  const getUser = computed(() => user)

  const loadUserFromLocalStorage = () => {
    const storedUser = localStorage.getItem(LOCAL_STORAGE_USER.USER);
    if (storedUser) {
      Object.assign(user, JSON.parse(storedUser));
    }
  };

  watch(user, (newUser) => {
    localStorage.setItem(LOCAL_STORAGE_USER.USER, JSON.stringify(newUser));
  }, {deep: true});

  loadUserFromLocalStorage();

  const registerUser = async (data) => {
    await AuthService.register(data);
  }
  const loginUser = async (data) => {
    const response = await AuthService.login(data);
    fillUserData(response.data.user);
    localStorage.setItem(LOCAL_STORAGE_KEY.LOGIN_TOKEN, response.data.token.access_token);
  }

  const fillUserData = (userData) => {
    Object.assign(user, userData);
  };

  const clearUserData = () => {
    Object.keys(user).forEach(key => user[key] = "");
    user.id = null;
  };

  const logoutUser = async () => {
    await AuthService.logout()
    clearUserData()
    localStorage.removeItem(LOCAL_STORAGE_KEY.LOGIN_TOKEN)
  }

  const getAllUsers = async () => {
    const response = await AdminService.getAllUsers();
    ListUsers.value = response.data;
  }

  const createUser = async (data) => {
    const response = await AdminService.createUser(data);
    ListUsers.value.push(response.data);
  };

  const updateUser = async (data) => {
    const response = await AdminService.updateUser(data);
    ListUsers.value = ListUsers.value.map(user => user.id === response.data.id ? response.data : user);
  }

  const deleteUser = async (id) => {
    await AdminService.deleteUser(id);
    ListUsers.value = ListUsers.value.filter(user => user.id !== id);
  };
  return {
    getUser,
    getListUsers,
    registerUser,
    loginUser,
    logoutUser,
    getAllUsers,
    createUser,
    deleteUser,
    updateUser,
  }
});