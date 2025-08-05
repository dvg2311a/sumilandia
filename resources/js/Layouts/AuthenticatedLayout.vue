<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

const sidebarCollapse = ref(null);
const containerPage = ref(null);

const toggleSidebar = () => {
    if (sidebarCollapse.value) {
        containerPage.value.classList.toggle('sidebar-collapsed');
    }
};

</script>

<template>

    <!-- Primary Navigation Menu -->
    <div class="container-page" ref="containerPage">
        <aside class="sidebar" ref="sidebarCollapse">
            <div class="items-sidebar">
                <!-- Logo -->
                <div class="logo-sidebar">
                    <Link :href="route('dashboard')">
                    <img src="/icons/logo-short.png" alt="Logo" class="logo-short" />
                    </Link>

                    <Link :href="route('dashboard')">
                    <ApplicationLogo />
                    </Link>


                    <img src="/icons/hamburguer.png" alt="Menu" class="hamburguer-icon" @click="toggleSidebar" />
                </div>

                <!-- Navigation Links -->
                <div class="nav-links">
                    <template v-if="$page.props.auth.user.roles && $page.props.auth.user.roles.includes('admin')">
                        <NavLink :href="route('units.index')" :active="route().current('units.index')">
                            <img src="/icons/themes-icon.gif" alt="Temas de estudio" class="icons-sidebar" />
                            <span class="hidden" style="--i:1">Temas de estudio</span>
                        </NavLink>
                        <NavLink :href="route('levels.index')" :active="route().current('levels.index')">
                            <img src="/icons/levels-icon.gif" alt="Niveles" class="icons-sidebar" />
                            <span class="hidden" style="--i:2">Niveles</span>
                        </NavLink>
                        <NavLink :href="route('lessons.index')" :active="route().current('lessons.index')">
                            <img src="/icons/lections-icon.gif" alt="Lecciones" class="icons-sidebar" />
                            <span class="hidden" style="--i:3">Lecciones</span>
                        </NavLink>
                        <NavLink :href="route('resources.index')" :active="route().current('resources.index')">
                            <img src="/icons/resources-icon.gif" alt="Recursos" class="icons-sidebar" />
                            <span class="hidden" style="--i:4">Recursos</span>
                        </NavLink>
                        <NavLink :href="route('exercises.index')" :active="route().current('exercises.index')">
                            <img src="/icons/challenge-icon.gif" alt="Ejercicios" class="icons-sidebar" />
                            <span class="hidden" style="--i:5">Ejercicios</span>
                        </NavLink>
                        <NavLink :href="route('admin.progress.index')"
                            :active="route().current('admin.progress.index')">
                            <img src="/icons/progress-icon.gif" alt="" class="icons-sidebar" />
                            <span class="hidden" style="--i:6">Progreso estudiantes</span>
                        </NavLink>
                    </template>
                    <template v-else>
                        <NavLink :href="route('student.units.index')" :active="route().current('student.units.index')">
                            <span class="hidden" style="--i:1"></span> Unidades
                        </NavLink>
                    </template>
                </div>
            </div>
            <!-- End Navigation links -->

            <!-- Settings Dropdown -->
            <div class="settings-dropdown">
                <Dropdown align="right" width="48">
                    <template #content>
                        <span class="dropdown-content">
                            <DropdownLink :href="route('profile.edit')">
                                <img src="/icons/profile-icon.gif" alt="Perfil" title="Perfil" class="img-logout" />
                                <span class="span-logout">Perfil</span>
                            </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                <img src="/icons/logout-icon.gif" alt="Cerrar sesión" title="Cerrar sesión"
                                    class="img-logout">
                                <span class="span-logout">Cerrar sesión</span>
                            </DropdownLink>
                        </span>
                    </template>

                    <template #trigger>
                        <span class="dropdown-trigger">
                            <img v-if="$page.props.auth.user.profile && $page.props.auth.user.profile.avatar_url"
                                :src="$page.props.auth.user.profile.avatar_url" alt="Avatar" class="img-sidebar" />
                            <button type="button" class="btn-profile" style="--i:7">
                                {{ $page.props.auth.user.full_name }}
                            </button>
                        </span>
                    </template>

                </Dropdown>
            </div>
        </aside>

        <!-- Page Heading -->
        <div class="container-menu-mobile">
            <div class="menu-mobile">
                <img src="/icons/hamburguer.png" alt="Menu" class="hamburguer-icon" @click="toggleSidebar" />
            </div>

            <div class="nav-links-mobile" ref="sidebarCollapse">
                        <NavLink :href="route('units.index')" :active="route().current('units.index')">
                            <img src="/icons/themes-icon.gif" alt="Temas de estudio" class="icons-sidebar" />
                            <span class="hidden" style="--i:1">Temas de estudio</span>
                        </NavLink>
                        <NavLink :href="route('levels.index')" :active="route().current('levels.index')">
                            <img src="/icons/levels-icon.gif" alt="Niveles" class="icons-sidebar" />
                            <span class="hidden" style="--i:2">Niveles</span>
                        </NavLink>
                        <NavLink :href="route('lessons.index')" :active="route().current('lessons.index')">
                            <img src="/icons/lections-icon.gif" alt="Lecciones" class="icons-sidebar" />
                            <span class="hidden" style="--i:3">Lecciones</span>
                        </NavLink>
                        <NavLink :href="route('resources.index')" :active="route().current('resources.index')">
                            <img src="/icons/resources-icon.gif" alt="Recursos" class="icons-sidebar" />
                            <span class="hidden" style="--i:4">Recursos</span>
                        </NavLink>
                        <NavLink :href="route('exercises.index')" :active="route().current('exercises.index')">
                            <img src="/icons/challenge-icon.gif" alt="Ejercicios" class="icons-sidebar" />
                            <span class="hidden" style="--i:5">Ejercicios</span>
                        </NavLink>
                        <NavLink :href="route('admin.progress.index')"
                            :active="route().current('admin.progress.index')">
                            <img src="/icons/progress-icon.gif" alt="" class="icons-sidebar" />
                            <span class="hidden" style="--i:6">Progreso estudiantes</span>
                        </NavLink>
            </div>
        </div>

        <!-- Page Content -->
        <main>
            <slot style="" />
        </main>
    </div>

</template>
