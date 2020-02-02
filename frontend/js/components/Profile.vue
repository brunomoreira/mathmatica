<template>
    <div class="profile" v-if="user">
        <md-layout md-row class="wrapper">
            <md-layout class="avatar">
                <md-whiteframe md-elevation="3">
                    <h1>Avatar</h1>
                    <md-card>
                        <md-card-area>
                            <md-card-media>
                                <img :src="user.full" alt="avatar">
                            </md-card-media>

                            <md-card-header>
                                <div class="md-title">{{ user.title }}</div>
                                <div class="md-subhead">
                                    <a :href="user.wiki" target="_blank">Wikipédia</a>
                                </div>
                            </md-card-header>

                            <md-card-content>
                                <p>{{ user.text }}</p>
                            </md-card-content>
                        </md-card-area>
                    </md-card>
                    <md-card>
                        <md-card-content v-show="displayUserData" class="user-data">
                            <div class="md-list-item-container">
                                <md-icon>email</md-icon>
                                <h3 class="data-title">Email</h3>
                                <p class="user-data">{{ user.email }}</p>
                            </div>
                            <div class="md-list-item-container">
                                <md-icon>face</md-icon>
                                <h3 class="data-title">Nome</h3>
                                <p class="user-data">{{ user.username }}</p>
                            </div>
                            <div class="md-list-item-container">
                                <md-icon>verified_user</md-icon>
                                <h3 class="data-title">Premium</h3>
                                <p class="user-data">{{ user.premium ? 'Sim' : 'Não' }}</p>
                            </div>
                            <div class="md-list-item-container">
                                <md-icon>date_range</md-icon>
                                <h3 class="data-title">Registo</h3>
                                <p class="user-data">{{ user.created_at | prettyDate }}</p>
                            </div>
                        </md-card-content>
                        <md-card-actions md-align="center">
                            <md-button id="edit-profile-button"
                                       class="md-raised md-primary"
                                       @click="openDialog('editDialog')"
                                       >Editar Perfil!
                            </md-button>
                            <md-button id="show-profile-button"
                                       class="md-raised md-warn"
                                       @click="displayUserData = !displayUserData"
                                       >Ver Dados!
                            </md-button>
                        </md-card-actions>
                    </md-card>
                </md-whiteframe>
            </md-layout>
            <md-layout class="modules">
                <md-whiteframe md-elevation="5">
                    <h1>Módulos</h1>
                    <md-layout>
                        <modules :user="user"></modules>
                    </md-layout>
                </md-whiteframe>
            </md-layout>
            <md-dialog md-open-from="#edit-profile-button" md-close-to="#edit-profile-button" ref="editDialog">
                <md-dialog-title>Editar Perfil!</md-dialog-title>
                <md-dialog-content>
                    <form novalidate>
                        <md-input-container>
                            <label for="field">Escolha uma opção!</label>
                            <md-select name="field" id="field" v-model="form.field">
                                <md-option value="avatar">Avatar</md-option>
                                <md-option value="email">Email</md-option>
                                <md-option value="username">Nome</md-option>
                                <md-option value="password">Palavra-Passe</md-option>
                            </md-select>
                        </md-input-container>
                        <md-input-container v-if="form.field == 'avatar'">
                            <label for="avatar">Avatar</label>
                            <md-select name="avatar" id="avatar" v-model="form.avatars">
                                <md-option :value="1">René Descartes</md-option>
                                <md-option :value="2">Pitágoras</md-option>
                                <md-option :value="3">Leonhard Euler</md-option>
                                <md-option :value="4">Leonardo Pisano Blgollo</md-option>
                                <md-option :value="5">Isaac Newton</md-option>
                                <md-option :value="6">Euclides</md-option>
                                <md-option :value="7">Carl Friedrich Gauss</md-option>
                                <md-option :value="8">Bernhard Riemann</md-option>
                                <md-option :value="9">Andrew Wiles</md-option>
                                <md-option :value="10">Alan Turing</md-option>
                            </md-select>
                        </md-input-container>
                        <md-input-container v-if="form.field == 'email'" :md-clearable="true" :class="{ 'md-input-invalid': $v.form.email.$dirty && $v.form.email.$invalid }">
                            <label for="email">Email</label>
                            <md-input v-model.trim="form.email" 
                                :required="!$v.form.email.required"
                                @input="$v.form.email.$touch()"
                                @blur="$v.form.email.$touch()">
                            </md-input>
                            <span class="md-error" v-if="!$v.form.email.email">Email Inválido!</span>
                            <span class="md-error" v-if="!$v.form.email.required">Preenchimento Obrigatório!</span>
                        </md-input-container>
                        <md-input-container v-if="form.field == 'username'" :md-clearable="true" :class="{ 'md-input-invalid': $v.form.username.$dirty && $v.form.username.$invalid }">
                            <label for="username">Nome</label>
                            <md-input v-model.trim="form.username" 
                                :required="!$v.form.username.required"
                                @input="$v.form.username.$touch()"
                                @blur="$v.form.username.$touch()">
                            </md-input>
                            <span class="md-error" v-if="!$v.form.username.required">Preenchimento Obrigatório!</span>
                        </md-input-container>
                        <md-input-container v-if="form.field == 'password'" :md-clearable="true" :class="{ 'md-input-invalid': $v.form.password.$dirty && $v.form.password.$invalid }">
                            <label for="password">Palavra-Passe</label>
                            <md-input type="password" 
                                v-model.trim="form.password" 
                                :required="!$v.form.password.required"
                                @input="$v.form.password.$touch()"
                                @blur="$v.form.password.$touch()">
                            </md-input>
                            <span class="md-error" v-if="!$v.form.password.required">Preenchimento Obrigatório!</span>
                        </md-input-container>
                        <md-input-container v-if="form.field == 'password'" :md-clearable="true" :class="{ 'md-input-invalid': $v.form.re_password.$dirty && $v.form.re_password.$invalid }">
                            <label for="re_password">Confirmar Palavra-Passe</label>
                            <md-input type="password"
                                v-model.trim="form.re_password" 
                                :required="!$v.form.re_password.required"
                                @input="$v.form.re_password.$touch()"
                                @blur="$v.form.re_password.$touch()">
                            </md-input>
                            <span class="md-error" v-if="!$v.form.re_password.sameAsPassword">As palavras passes não são iguais!</span>
                        </md-input-container>
                    </form>
                </md-dialog-content>
                <md-dialog-actions>
                    <md-button class="md-raised md-primary" :disabled="$v.form.$invalid || formLoading" @click="edit()">Guardar!</md-button>
                </md-dialog-actions>
                <md-layout class="form-loading" md-row md-align="center" v-show="formLoading">
                    <md-spinner :md-size="35" md-indeterminate></md-spinner>
                </md-layout>
            </md-dialog>
        </md-layout>
    </div>
</template>

<script>

import Modules from './Modules'
import moment from 'moment'
import { required, email, sameAs, between } from 'vuelidate/lib/validators'
import axios from 'axios'

export default {
    name: 'profile',
    components: { Modules },
    data() {
        return {
            form: {
                field: 'avatar',
                avatars: 1,
                email: '',
                username: '',
                password: '',
                re_password: ''
            },
            formLoading: false,
            displayUserData: false
        }
    },
    validations() {
        switch(this.form.field) {
            case 'avatar':
                return {
                    form: {
                        avatars: {
                            between: between(1, 10)
                        }
                    }
                }
            case 'email':
                return {
                    form: {
                        email: {
                            email,
                            required
                        }
                    }
                }
            case 'username':
                return {
                    form: {
                        username: {
                            required
                        }
                    }
                }
            case 'password':
                return {
                    form: {
                        password: {
                            required
                        },
                        re_password: {
                            sameAsPassword: sameAs('password')
                        }
                    }
                }
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        }
    },
    filters: {
        prettyDate(date) {
            return moment(date).format("D-MM-YYYY")
        }
    },
    methods: {
        clear() {
            this.form.field = 'avatar'
            this.form.avatars = 1
            this.form.email = ''
            this.form.username = ''
            this.form.password = ''
            this.form.re_password = ''
        },
        openDialog(ref) {
            this.$refs[ref].open();
        },
        edit() {
            
            this.formLoading = true

            let data

            switch(this.form.field) {
                case 'avatar':
                    data = {
                        field: this.form.field,
                        value: this.form.avatars
                    }
                    break
                case 'email':
                    data = {
                        field: this.form.field,
                        value: this.form.email
                    }
                    break
                case 'username':
                    data = {
                        field: this.form.field,
                        value: this.form.username
                    }
                    break
                case 'password':
                    data = {
                        field: this.form.field,
                        value: this.form.password
                    }
                    break
                default:
                    return data = {
                        field: null,
                        value: null
                    }
            }

            axios.post('/user/profile/edit', data).then(response => {
                
                const data = response.data

                if(data.status != 200) {

                    this.$store.commit('addNotification', {
                        id: Date.now(),
                        type: 'error',
                        body: data.message,
                        autoClear: false
                    })

                    return this.formLoading = false

                }

                this.$store.commit('changeUser', data.user)

                this.$store.commit('addNotification', {
                    id: Date.now(),
                    type: 'success',
                    body: data.message,
                    autoClear: true
                })
                
                this.clear()

                return this.formLoading = false
            
            }).catch(error => {
                
                this.$store.commit('addNotification', {
                    id: Date.now(),
                    type: 'error',
                    body: error.message,
                    autoClear: false
                })

                return this.formLoading = false

            })

            return this.formLoading = false

        }
    }
}

</script>

<style lang="scss" scoped>

$red: #e53935;
$blue: #2196F3;

.wrapper
{
    align-items: flex-start;
}

.avatar,
.data,
.modules
{
    padding: 20px;
    justify-content: center;
    flex-direction: column;

    h1
    {
        text-align: center;
        margin: 0 0 20px 0;
        padding: 20px;
        background: $blue;
        color: white;
    }

    @media (max-width: 768px)
    {
        min-width: 100%;
        flex: 0 1 100%;
    }

}

.md-card
{
    align-items: center;

    .md-card-header, .md-card-content
    {
        text-align: center;
    }

    .md-card-actions
    {
        padding: 0px 0px 20px 0;
        margin-top: 20px;
    }

}

.md-list-item-container
{
    margin: 0 0 20px 0;
    text-align: center;

    .data-title
    {
        display: inline-flex;
        vertical-align: middle;
    }

    .user-data
    {
        margin: 5px 0 0 0;
    }
}

.md-dialog
{

    .md-dialog-title
    {
        text-align: center;
        background: $blue;
        padding: 20px;
        color: white;
    }

    .md-dialog-actions
    {
        justify-content: center;
        margin-bottom: 10px;
    }

    .form-loading
    {
        margin: 0 0 20px 0;
    }
}

.user-data
{
    margin-bottom: -30px;
}

</style>
