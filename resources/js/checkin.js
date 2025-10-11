import axios from "axios";

const form = document.getElementById("checkinForm");
const message = document.getElementById("responseMessage");
const btnSubmit = document.getElementById("btnSubmit");

form.addEventListener("submit", async (e) => {
    e.preventDefault();
    message.innerHTML = "";
    btnSubmit.disabled = true;
    btnSubmit.innerText = "Memproses...";

    if (!navigator.geolocation) {
        message.innerHTML = `<p class="text-red-500">Perangkat tidak mendukung geolocation.</p>`;
        btnSubmit.disabled = false;
        btnSubmit.innerText = "Masuk";
        return;
    }

    navigator.geolocation.getCurrentPosition(
        async (pos) => {
            const latitude_position = pos.coords.latitude;
            const longitude_position = pos.coords.longitude;

            const formData = {
                username: document.getElementById("username").value,
                password: document.getElementById("password").value,
                point_qr_id: document.getElementById("point_qr_id").value,
                latitude: latitude_position,
                longitude: longitude_position,
            };

            try {
                const response = await axios.post("/lapor-checkin", formData, {
                    headers: { Accept: "application/json" },
                });

                if (response.data.success) {
                    message.innerHTML = `<p class="text-green-600 font-medium">✅ ${response.data.message}</p>`;
                    form.reset();
                } else {
                    message.innerHTML = `<p class="text-red-500">${
                        response.data.message || "Gagal melakukan check-in."
                    }</p>`;
                }
            } catch (error) {
                if (error.response) {
                    const res = error.response;
                    if (res.status === 401) {
                        message.innerHTML = `<p class="text-red-500">❌ Username atau password salah.</p>`;
                    } else if (res.status === 422) {
                        message.innerHTML = `<p class="text-red-500">❌ Validasi gagal, periksa input Anda.</p>`;
                    } else {
                        message.innerHTML = `<p class="text-red-500">⚠️ ${
                            res.data.message || "Terjadi kesalahan server."
                        }</p>`;
                    }
                } else {
                    message.innerHTML = `<p class="text-red-500">⚠️ Tidak dapat terhubung ke server.</p>`;
                }
            }

            btnSubmit.disabled = false;
            btnSubmit.innerText = "Masuk";
        },
        (err) => {
            console.error(err);
            console.warn("Tidak dapat mengambil lokasi:", err.message);
            message.innerHTML = `<p class="text-red-500">Tidak dapat mengakses lokasi, pastikan GPS aktif.</p>`;
            btnSubmit.disabled = false;
            btnSubmit.innerText = "Masuk";
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0,
        }
    );
});
