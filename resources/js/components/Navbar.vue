<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid px-lg-5">

            <a class="navbar-brand" :href="routes.home">
                <img
                    src=""
                    alt="OwnAcres"
                    height="45"
                >
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div
                class="collapse navbar-collapse"
                id="navbarSupportedContent"
            >
                <ul class="navbar-nav mx-auto">

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            :href="routes.home"
                        >
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            :href="routes.marketplace"
                        >
                            Marketplace
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            :href="routes.dealers"
                        >
                            Dealers
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            :href="routes.blogs"
                        >
                            Education
                        </a>
                    </li>

                </ul>
            </div>

        </div>
    </nav>
</template>

<script setup>
const routes = window.routes;
</script>