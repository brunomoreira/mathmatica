<template>
  <div class="navbar">
    <md-toolbar class="main-nav">
        <md-button class="md-icon-button" @click="toggleLeftSidenav()">
            <md-icon>menu</md-icon>
        </md-button>
        <ul>
            <li>
                <router-link to="welcome">Bem Vindo!</router-link>
            </li>
            <li v-if="!user">
                <router-link to="login">Entrar</router-link>
            </li>
            <li v-if="!user">
                <router-link to="register">Registar</router-link>
            </li>
            <li>
                <router-link to="test">Test</router-link>
            </li>
        </ul>
        <ul class="logout" v-if="user">
            <li>
                <md-menu class="profile-menu"
                         :md-size="5"
                         :md-align-trigger="true"
                         :md-offset-y="10"
                         md-direction="bottom left">
                    <md-avatar md-menu-trigger>
                        <img :src="user.avatar" alt="Avatar">
                    </md-avatar>
                    <md-menu-content>
                        <md-card>
                            <md-card-media>
                                <img :src="user.full" alt="avatar-full">
                            </md-card-media>
                            <md-card-header>
                                <div class="md-title">{{ user.username }}</div>
                            </md-card-header>
                        </md-card>
                        <router-link tag="md-button" to="/profile" class="md-menu-item">Perfil!</router-link>
                        <md-button @click="logout()" class="md-menu-item md-raised md-accent">Sair!</md-button>
                    </md-menu-content>
                </md-menu>
            </li>
        </ul>
    </md-toolbar>

    <!-- Left Sidenav -->
    <md-sidenav class="md-left sidenav" ref="leftSidenav">
        <md-toolbar>
            <div class="md-toolbar-container">
                <h3 class="md-title">Mathmatica</h3>
            </div>
        </md-toolbar>
        <md-list class="sidenav-links">
            <md-list-item>
                <router-link to="welcome">
                    <md-icon>home</md-icon>
                    <p>Bem Vindo!</p>
                </router-link>
            </md-list-item>
            <md-list-item v-if="!user">
                <router-link to="login">
                    <md-icon>account_box</md-icon>
                    <p>Entrar!</p>
                </router-link>
            </md-list-item>
            <md-list-item v-if="!user">
                <router-link to="register">
                    <md-icon>verified_user</md-icon>
                    <p>Registar!</p>
                </router-link>
            </md-list-item>
            <md-list-item v-if="user">
                <router-link to="profile">
                    <md-avatar>
                        <img :src="user.avatar" alt="Avatar">
                    </md-avatar>
                    <p>Perfil</p>
                </router-link>
            </md-list-item>
            <md-list-item>
                <router-link to="test">
                    <md-icon>build</md-icon>
                    <p>Test</p>
                </router-link>
            </md-list-item>
        </md-list>
        <md-list class="logout-sidenav-container" v-if="user">
            <md-list-item>
                <md-button @click="logout()" class="md-raised md-accent">Sair!</md-button>
            </md-list-item>
        </md-list>
    </md-sidenav>

  </div>
</template>

<script>

import axios from 'axios'

export default {
    name: 'navbar',
    props: ['direction'],
    computed: {
        user() {
            return this.$store.state.user
        }
    },
    methods: {
        toggleLeftSidenav() {
            return this.$refs.leftSidenav.toggle()
        },
        logout() {
            axios.get('/user/logout').then(response => {
                
                const data = response.data

                if(data.hasLoggedOut) {
                    this.$store.commit('changeUser', null)
                }
            })

            return this.$router.push('welcome')
        }
    }
}
</script>

<style lang="scss" scoped>

$blue: #2196F3;
$green: mediumseagreen;

.navbar
{

    .md-theme-default.md-toolbar
    {
        background: white;
        color: $blue;
        box-shadow: 1px 1px 7px silver;
    }

    .sidenav
    {

        @media (min-width: 769px) {
            display: none;
        }

        .md-toolbar
        {
            padding: 0;

            .md-toolbar-container
            {
                justify-content: center;
                background: $green;

                .md-title
                {
                    margin: 0;
                    color: white;
                }
            }
        }

        .md-list
        {
            padding: 0;

            .md-list-item-container
            {
                justify-content: center;
                width: 100%;
                border-radius: 0;

                &.router-link-active { 
                    background: $blue;
                    
                    .md-icon,
                    p
                    {
                        color: white;
                    }

                }

                .md-icon
                {
                    margin-right: 10px;
                }

                p
                {
                    font-weight: bolder;
                    flex: none;
                }

            }
        }
    }

    .md-toolbar>.md-button:first-child
    {
        margin-right: 0;
    }

    .main-nav
    {
        padding: 0 20px;

        .logout
        {
            flex: 1;
            justify-content: flex-end;
        }

        ul
        {
            list-style-type: none;
            display: flex;
            flex: 1;
            justify-content: center;
            align-items: center;
            padding-left: 0;

            li
            {
                margin-right: 40px;
                margin-top: 0;
                &:last-child { margin-right: 0; }

                a
                {
                    color: $blue;
                    padding: 5px 0px;
                    font-weight: bold;
                    font-size: 1.1rem;
                    border-bottom: 2px solid white;
                    &:hover { text-decoration: none; color:$blue; }
                }

            }

            .router-link-active
            {
                border-bottom: 2px solid $blue;
                color: $blue;
                transition: all 300ms ease-in-out;
                &:hover { text-decoration: none; }
            }

            @media (max-width: 768px)
            {
                display: none;
            }
        }

        .md-icon-button
        {
            @media (min-width: 769px)
            {
                display: none;
            }
        }
    }

    .md-card-header
    {
        text-align: center;
        margin: 0;
    }

}

</style>



