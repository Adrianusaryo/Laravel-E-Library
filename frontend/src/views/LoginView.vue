<template>
    <section class="login d-flex vh-100">
        <div class="login-left w-50 h-100 bg-light-subtle">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-7">
                    <div class="header text-center">
                        <h2 class="fw-semibold text-dark">
                            <i class="fa fa-book-open px-2"></i>
                            E-Library
                        </h2>
                        <p class="text-muted fs-6">
                            Access your account to explore a world of knowledge and borrow your
                            favorite books.
                        </p>
                    </div>
                    <div class="login-form">
                        <form @submit.prevent="">
                            <div class="mb-2">
                                <label for="email" class="form-label fw-medium text-dark"
                                    >Email</label
                                >
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    placeholder="Masukan Email "
                                    v-model="email"
                                    :class="{ 'is-invalid': errors.email }"
                                />
                                <div v-if="errors.email" class="invalid-feedback">
                                    {{ errors.email[0] }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium text-dark"
                                    >Password</label
                                >
                                <div class="input-group">
                                    <input
                                        :type="showPassword ? 'text' : 'password'"
                                        class="form-control"
                                        id="password"
                                        placeholder="Masukan Password"
                                        v-model="password"
                                        :class="{ 'is-invalid': errors.password }"
                                    />
                                    <span
                                        class="input-group-text text-dark"
                                        @click="togglePassword"
                                        style="cursor: pointer"
                                    >
                                        <i
                                            :class="showPassword ? 'fas fa-unlock' : 'fas fa-lock'"
                                        ></i>
                                    </span>
                                </div>
                                <div v-if="errors.password" class="invalid-feedback">
                                    {{ errors.password[0] }}
                                </div>
                            </div>

                            <button @click="login()" class="btn btn-dark w-100">Login</button>
                        </form>
                        <div class="text-center mt-2">
                            <span class="text-muted"
                                >Don't have an account ?
                                <RouterLink to="/register" class="text-dark fst-italic fw-medium"
                                    >Sign up for free</RouterLink
                                >
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="login-right w-50 h-100">
            <div
                id="carouselExampleFade"
                class="carousel slide carousel-fade"
                data-bs-ride="carousel"
                data-bs-pause="false"
            >
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="4000">
                        <img src="@/assets/image/perpus1.jpg" class="d-block w-100" alt="..." />
                    </div>
                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="@/assets/image/perpus2.jpg" class="d-block w-100" alt="..." />
                    </div>
                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="@/assets/image/perpus3.jpg" class="d-block w-100" alt="..." />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import axios from 'axios'
import router from '@/router'
export default {
    data() {
        return {
            email: '',
            password: '',
            errors: {},
            showPassword: false,
        }
    },
    methods: {
        login() {
            axios
                .post('http://127.0.0.1:8000/api/Auth/Login', {
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    sessionStorage.setItem('email', response.data.data.email)
                    sessionStorage.setItem('name', response.data.data.name)
                    sessionStorage.setItem('token', response.data.data.token)
                    sessionStorage.setItem('tanggal_lahir', response.data.data.tanggal_lahir)

                    // Hitung Usia
                    const today = new Date()
                    const birthDate = new Date(response.data.data.tanggal_lahir)
                    let age = today.getFullYear() - birthDate.getFullYear()
                    const monthDiff = today.getMonth() - birthDate.getMonth()
                    if (
                        monthDiff < 0 ||
                        (monthDiff == 0 && today.getDate() < birthDate.getDate())
                    ) {
                        age--
                    }

                    if (age >= 6 && age <= 12) {
                        router.push({ name: 'anak-anak' })
                    } else if (age >= 13 && age <= 21) {
                        router.push({ name: 'remaja' })
                    } else {
                        router.push({ name: 'dewasa' })
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        togglePassword() {
            this.showPassword = !this.showPassword
        },
    },
    mounted() {
        this.token = sessionStorage.getItem('token')
        if (this.token) {
            router.push({ name: 'home' })
        }
    },
}
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

.login {
    font-family: 'Roboto', sans-serif;
}

.bg-dark {
    background-color: #f4f6f9 !important;
}

.text-dark {
    color: #344767 !important;
}

.btn-dark {
    background-color: #344767 !important;
}

.carousel-inner {
    height: 100vh;
    display: flex;
    align-items: center;
}

.carousel-item {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.carousel-item img {
    max-height: 100vh;
    width: auto;
    object-fit: cover;
    object-position: center center;
}

.form-control:focus {
    border-color: #344767 !important;
    box-shadow: 0 0 0 0.2rem rgba(52, 71, 103, 0.25) !important;
}
</style>
