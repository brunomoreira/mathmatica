<template>
  <div class="register wrapper">
    <md-layout md-row md-align="center">
      <form novalidate @submit.stop.prevent="register()">
        <md-input-container :md-clearable="true" :class="{ 'md-input-invalid': $v.form.email.$dirty && $v.form.email.$invalid }">
          <md-icon>mail_outline</md-icon>
          <label>Email</label>
          <md-input v-model.trim="form.email" 
                    :required="!$v.form.email.required"
                    @input="$v.form.email.$touch()"
                    @blur="$v.form.email.$touch()">
          </md-input>
          <span class="md-error" v-if="!$v.form.email.email">Email Inválido!</span>
          <span class="md-error" v-if="!$v.form.email.required">Preenchimento Obrigatório!</span>
        </md-input-container>
        <md-input-container :md-clearable="true" :class="{ 'md-input-invalid': $v.form.username.$dirty && $v.form.username.$invalid }">
          <md-icon>face</md-icon>
          <label>Nome de Utilizador</label>
          <md-input v-model.trim="form.username" 
                    :required="!$v.form.username.required"
                    @input="$v.form.username.$touch()"
                    @blur="$v.form.username.$touch()">
          </md-input>
          <span class="md-error" v-if="!$v.form.username.required">Preenchimento Obrigatório!</span>
        </md-input-container>
        <md-input-container :md-clearable="true" :class="{ 'md-input-invalid': $v.form.password.$dirty && $v.form.password.$invalid }">
          <md-icon>vpn_key</md-icon>
          <label>Palavra-Passe</label>
          <md-input type="password" 
                    v-model.trim="form.password" 
                    :required="!$v.form.password.required"
                    @input="$v.form.password.$touch()"
                    @blur="$v.form.password.$touch()">
          </md-input>
          <span class="md-error" v-if="!$v.form.password.required">Preenchimento Obrigatório!</span>
        </md-input-container>
        <md-input-container :md-clearable="true" :class="{ 'md-input-invalid': $v.form.re_password.$dirty && $v.form.re_password.$invalid }">
          <md-icon>vpn_key</md-icon>
          <label>Confirmar Palavra-Passe</label>
          <md-input type="password" 
                    v-model.trim="form.re_password" 
                    :required="!$v.form.re_password.required"
                    @input="$v.form.re_password.$touch()"
                    @blur="$v.form.re_password.$touch()">
          </md-input>
          <span class="md-error" v-if="!$v.form.re_password.sameAsPassword">As palavras passes não são iguais!</span>
        </md-input-container>
        <md-input-container>
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
        <md-layout md-row md-align="center">
          <md-button type="submit" :disabled="$v.form.$invalid || formLoading" class="md-raised md-primary">Registar!</md-button>
          <md-button type="reset" class="md-raised md-accent">Limpar!</md-button>
        </md-layout>
      </form>
    </md-layout>
    <md-layout class="form-loading" md-row md-align="center" v-show="formLoading">
      <md-spinner :md-size="35" md-indeterminate></md-spinner>
    </md-layout>
  </div>
</template>

<script>

import { required, email, sameAs, between } from 'vuelidate/lib/validators'
import axios from 'axios'

export default {
    name: 'register',
    data() {
        return {
            form: {
                email: '',
                username: '',
                password: '',
                re_password: '',
                avatars: 1,
            },
            formLoading: false
        }
    },
    validations: {
        form: {
            email: {
                required,
                email
            },
            username: {
                required
            },
            password: {
                required
            },
            re_password: { 
                sameAsPassword: sameAs('password') 
            },
            avatars: {
                between: between(1, 10)
            }
        }
    },
    methods: {
        clear() {
            this.form.email = ''
            this.form.username = ''
            this.form.password = ''
            this.form.re_password = ''
            this.form.avatars = 1
        },
        register() {

            this.formLoading = true
      
            const data = {
                email: this.form.email,
                username: this.form.username,
                password: this.form.password,
                re_password: this.form.re_password,
                avatar: this.form.avatars,
            }

            axios.post('/user/register', data).then(response => {

                const data = response.data

                if(data.status != 200) {

                    this.$store.commit('addNotification', {
                        id: Date.now(),
                        type: 'error',
                        body: data.error,
                        autoClear: false
                    })
                
                } else {

                    this.clear()

                    this.$store.commit('addNotification', {
                        id: Date.now(),
                        type: 'success',
                        body: data.message,
                        autoClear: false
                    })

                }

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

        }
  }
}
</script>

<style lang="scss" scoped>

$blue: #2196F3;

form
{
    width: 80%;
    margin: 40px 0 0 0;

    label,
    .md-input-focused
    {
        color: $blue;
    }

    .md-input
    {
      border-bottom: 1px solid $blue;
    }

}

</style>
