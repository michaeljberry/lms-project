import { useEffect, useState } from "react";
import { http } from "../lib/http";

type HealthResponse = { status: string };

export default function HealthPage() {
  const [status, setStatus] = useState<"idle" | "loading" | "ok" | "error">("idle");
  const [message, setMessage] = useState<string>("");
  const [latency, setLatency] = useState<number | null>(null);

  async function fetchHealth(signal?: AbortSignal) {
    try {
      setStatus("loading");
      setMessage("");
      setLatency(null);
      const t0 = performance.now();
      const { data } = await http.get<HealthResponse>("/api/health", { signal });
      const t1 = performance.now();
      setLatency(Math.round(t1 - t0));
      setStatus(data?.status === "ok" ? "ok" : "error");
      setMessage(JSON.stringify(data));
    } catch (err: any) {
      setStatus("error");
      setMessage(err?.response?.data ? JSON.stringify(err.response.data) : err?.message || "Request failed");
    }
  }

  useEffect(() => {
    const controller = new AbortController();
    fetchHealth(controller.signal);
    return () => controller.abort();
  }, []);

  const badge =
    status === "ok"
      ? "bg-green-100 text-green-800 ring-green-600/20"
      : status === "error"
      ? "bg-red-100 text-red-800 ring-red-600/20"
      : status === "loading"
      ? "bg-yellow-100 text-yellow-800 ring-yellow-600/20"
      : "bg-gray-100 text-gray-800 ring-gray-600/20";

  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-50">
      <div className="w-full max-w-xl bg-white rounded-2xl shadow p-6">
        <div className="flex items-center justify-between mb-4">
          <h1 className="text-xl font-semibold">API Health</h1>
          <span className={`inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset ${badge}`}>
            {status.toUpperCase()}
          </span>
        </div>

        <p className="text-sm text-gray-600 mb-3">
          Checking <code className="px-1 py-0.5 bg-gray-100 rounded">/api/health</code> on{" "}
          <code className="px-1 py-0.5 bg-gray-100 rounded">{import.meta.env.VITE_API_BASE_URL ?? window.location.origin}</code>
        </p>

        <div className="border rounded-lg bg-gray-50 p-3 text-sm font-mono overflow-x-auto mb-4">
          {status === "loading" ? "Loading…" : message || "—"}
        </div>

        <div className="flex items-center justify-between">
          <button
            onClick={() => fetchHealth()}
            className="rounded-xl px-4 py-2 bg-black text-white hover:bg-gray-800 transition"
            disabled={status === "loading"}
          >
            {status === "loading" ? "Checking…" : "Re-check"}
          </button>
          <div className="text-sm text-gray-600">{latency !== null ? `~${latency} ms` : ""}</div>
        </div>

        <div className="mt-4 text-xs text-gray-500">
          Tip: If this page shows 404, make sure the backend route exists in <code>routes/api.php</code> and that{" "}
          <code>VITE_API_BASE_URL</code> points to your Laravel host (e.g., <code>http://127.0.0.1:8000</code>).
        </div>
      </div>
    </div>
  );
}