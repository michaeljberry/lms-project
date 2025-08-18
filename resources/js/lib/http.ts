// resources/js/lib/http.ts
import axios from "axios";

export const http = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL ?? window.location.origin,
  headers: { "Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest" },
  withCredentials: false,
});
