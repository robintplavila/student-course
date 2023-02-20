<script>
/**
 * Left sidebar component - contains mainly the application menu
 */

export default {
  data() {
    return {
    }
  },

}
</script>

<template>
    <!--- Main menu -->
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <router-link tag="a" to="/users" class="nav-link dropdown-toggle arrow-none">
                <em class="mdi mdi-clipboard-account me-1"></em>{{ $t("menu.Gebruikers") }}
            </router-link>
        </li>
    </ul>

    <!-- Main menu End -->
</template>

