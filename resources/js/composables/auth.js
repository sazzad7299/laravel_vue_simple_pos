import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import { userStore } from "../stores/user";

export default function useAuth() {
  const processing = ref(false);
  const validationErrors = ref({});
  const router = useRouter();
  const auth = userStore();
  const loginForm = reactive({
    email: "",
    password: "",
    remember: false,
  });
  const forgotForm = reactive({
    email: "",
  });

  const submitLogin = async () => {
    if (processing.value) return;

    processing.value = true;
    validationErrors.value = {};

    axios
      .post("/login", loginForm)
      .then(async (response) => {
        await loginUser(response.data.result.user);
        toastr.success(response.data.message);
      })
      .catch((error) => {
        toastr.error(error.response.data.message);
        if (error.response?.data) {
          validationErrors.value = error.response.data.errors;
        }
      })
      .finally(() => (processing.value = false));
  };

  const loginUser = async (data) => {
    auth.setUser(data);
    localStorage.setItem("user_access_token", data.token);
    await router.push({ name: "dashboard" });
  };

  const logout = () => {
    if (processing.value) return;
    processing.value = true;

    axios
      .post("/logout")
      .then((response) => {
        router.push({ name: "login" });
        auth.setUser(null);
        localStorage.removeItem("user_access_token");
        toastr.success(response.data.message);
      })
      .catch((error) => {
        console.log(error);
      })
      .finally(() => {
        processing.value = false;
      });
  };
  const submitForgotPassword = async () => {
    if (processing.value) return;

    processing.value = true;
    validationErrors.value = {};
    console.log(registerForm);
    axios
      .post("/forgot-password", forgotForm)
      .then(async (response) => {
        if (response.data.status === 200) {
          toastr.success(response.data.message);
          await router.push({ name: "login" });
        }
      })
      .catch((error) => {
        if (error.response?.data) {
          validationErrors.value = error.response.data.errors;
        }
      })
      .finally(() => (processing.value = false));
  };
  return {
    loginForm,
    forgotForm,
    validationErrors,
    processing,
    submitLogin,
    logout,
    submitForgotPassword,
  };
}
