import axios from "axios";

document.addEventListener("DOMContentLoaded", async () => {
    const form = document.getElementById("checkinForm");
    const message = document.getElementById("responseMessage");
    const btnSubmit = document.getElementById("btnSubmit");
    const video = document.getElementById("cameraStream");
    const canvas = document.getElementById("snapshotCanvas");
    const btnCapture = document.getElementById("btnCapture");
    const previewImage = document.getElementById("previewImage");
    const photoInput = document.getElementById("photo");

    // 🔒 Awal: tombol "Masuk" dinonaktifkan
    btnSubmit.disabled = true;
    btnSubmit.classList.add("cursor-not-allowed", "bg-sky-400");
    btnSubmit.classList.remove("bg-sky-600", "hover:bg-sky-700");

    // 🎥 Aktifkan kamera
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: "user" }, // otomatis pilih kamera depan jika tersedia
        });
        video.srcObject = stream;
    } catch (error) {
        alert("Gagal mengakses kamera. Pastikan izin diberikan dan perangkat memiliki kamera.");
        console.error(error);
        return;
    }

    // 📸 Ambil foto
    btnCapture.addEventListener("click", () => {
        const context = canvas.getContext("2d");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = canvas.toDataURL("image/png");
        photoInput.value = imageData;

        previewImage.src = imageData;
        previewImage.classList.remove("hidden");

        video.classList.add("hidden");
        btnCapture.textContent = "Foto Diambil ✅";
        btnCapture.disabled = true;

        // Aktifkan tombol submit setelah foto diambil
        btnSubmit.disabled = false;
        btnSubmit.classList.remove("cursor-not-allowed", "bg-sky-400");
        btnSubmit.classList.add("bg-sky-600", "hover:bg-sky-700");
        message.textContent = "";
    });

    // 🧭 Submit Form
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        message.innerHTML = "";

        // Validasi: pastikan foto sudah diambil
        if (!photoInput.value) {
            message.innerHTML = `<p class="text-red-500">Silakan ambil foto terlebih dahulu sebelum masuk.</p>`;
            return;
        }

        btnSubmit.disabled = true;
        btnSubmit.innerText = "Memproses...";

        // Cek dukungan geolocation
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

                // Buat data yang dikirim ke API
                const formData = {
                    username: document.getElementById("username").value,
                    password: document.getElementById("password").value,
                    point_qr_id: document.getElementById("point_qr_id").value,
                    latitude: latitude_position,
                    longitude: longitude_position,
                    foto_bukti: photoInput.value, // ✅ kirim foto base64
                };

                try {
                    const response = await axios.post("/lapor-checkin", formData, {
                        headers: { Accept: "application/json" },
                    });

                    if (response.data.success) {
                        message.innerHTML = `<p class="text-green-600 font-medium">✅ ${response.data.message}</p>`;
                        form.reset();

                        // Reset tampilan kamera
                        previewImage.classList.add("hidden");
                        video.classList.remove("hidden");
                        btnCapture.textContent = "Ambil Foto";
                        btnCapture.disabled = false;
                        btnSubmit.disabled = true;
                        btnSubmit.innerText = "Masuk";
                        btnSubmit.classList.add("cursor-not-allowed", "bg-sky-400");
                        btnSubmit.classList.remove("bg-sky-600", "hover:bg-sky-700");
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
});
