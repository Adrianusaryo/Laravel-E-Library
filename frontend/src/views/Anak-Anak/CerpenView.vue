<template>
    <div class="d-flex">
        <NavbarAnak :name="name" />
        <div class="flex-grow-1 px-4">
            <div class="container">
                <h5 class="fw-bold mt-4 text-dark" style="line-height: 10px">
                    Daftar Koleksi Cerpen
                </h5>
                <p class="text-muted mb-4">Tingkatkan literasi membacamu hari ini!</p>

                <form class="d-flex align-items-center mb-4" role="search">
                    <input
                        class="form-control me-2 rounded"
                        type="search"
                        placeholder="Cari cerpen"
                        aria-label="Search"
                    />
                    <button class="btn btn-dark rounded-pill" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                <div
                    class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3"
                    v-if="cerpen.length"
                >
                    <div class="col" v-for="(cerpen, index) in cerpen" :key="index">
                        <div
                            class="card h-100 shadow-sm border-0 position-relative"
                            style="overflow: hidden; border-radius: 8px; cursor: pointer"
                            @click="goToDetail(cerpen)"
                        >
                            <img
                                :src="cerpen.poster ? url + cerpen.poster : defaultCover"
                                class="card-img-top"
                                alt="cover buku"
                                style="
                                    object-fit: cover;
                                    height: 300px;
                                    width: 100%;
                                    transition: transform 0.3s ease;
                                "
                            />

                            <div
                                class="title-overlay position-absolute bottom-0 start-0 w-100 text-white text-center px-3 py-3"
                                style="
                                    font-weight: 700;
                                    font-size: 1rem;
                                    user-select: none;
                                    z-index: 2;
                                "
                            >
                                {{ cerpen.judul }}
                            </div>

                            <div
                                class="position-absolute bottom-0 start-0 w-100"
                                style="
                                    height: 80px;
                                    background: linear-gradient(
                                        to top,
                                        rgba(0, 0, 0, 0.6),
                                        transparent
                                    );
                                    z-index: 1;
                                "
                            ></div>
                        </div>
                    </div>
                </div>
                <div
                    v-else
                    class="d-flex flex-column align-items-center justify-content-center text-center p-5"
                >
                    <div
                        class="spinner-border text-dark mb-3"
                        role="status"
                        style="width: 3rem; height: 3rem"
                    >
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted fw-semibold mb-0" style="font-size: 1.1rem">
                        Sedang memuat koleksi cerpen...
                    </p>
                    <small class="text-muted">Mohon tunggu sebentar ya!</small>
                </div>

                <!-- <nav aria-label="Pagination" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item" :class="{ disabled: currentPage === 1 }">
                            <a href="#" class="page-link" @click.prevent="loadBuku(currentPage - 1)"
                                >&laquo;</a
                            >
                        </li>
                        <li
                            class="page-item"
                            v-for="page in totalPages"
                            :key="page"
                            :class="{ active: currentPage === page }"
                        >
                            <a href="#" class="page-link" @click.prevent="loadBuku(page)">{{
                                page
                            }}</a>
                        </li>
                        <li class="page-item" :class="{ disabled: currentPage === lastPage }">
                            <a href="#" class="page-link" @click.prevent="loadBuku(currentPage + 1)"
                                >&raquo;</a
                            >
                        </li>
                    </ul>
                </nav> -->
            </div>
            <FooterRemaja />
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import FooterRemaja from '@/components/FooterRemaja.vue'
import NavbarAnak from '@/components/NavbarAnak.vue'
import defaultCover from '../../../../frontend/src/assets/image/sapi.jpeg'

export default {
    components: {
        NavbarAnak,
        FooterRemaja,
    },
    data() {
        return {
            name: '',
            token: '',
            cerpen: [],
            defaultCover,
            url: 'http://127.0.0.1:8000/storage/Cerpen/',
        }
    },
    mounted() {
        this.token = sessionStorage.getItem('token')
        this.name = sessionStorage.getItem('name')
        this.loadCerpen()
    },
    methods: {
        loadCerpen() {
            axios
                .get(`http://127.0.0.1:8000/api/Cerpen/LihatCerpen`, {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then((response) => {
                    this.cerpen = response.data.data
                })
                .catch((error) => {
                    console.error('Gagal memuat buku:', error)
                })
        },
        goToDetail(cerpen) {
            sessionStorage.setItem('cerpen_id', cerpen.id)
            this.$router.push({ name: 'cerpenanakdetail' })
        },
    },
}
</script>
<style scoped>
.bg-dark-plus {
    background-color: #6f4e95 !important;
    color: white;
}

.btn-dark {
    background-color: #6f4e95 !important;
    border-color: #6f4e95 !important;
}

.text-dark {
    color: #6f4e95 !important;
}

.active > .page-link,
.page-link.active {
    z-index: 3;
    color: white;
    background-color: #6f4e95;
    border-color: #6f4e95;
}

.form-control:focus {
    border-color: #6f4e95 !important;
    box-shadow: 0 0 0 0.25rem rgba(111, 78, 149, 0.25);
}
</style>
