<template>
    <div class="module" v-if="module">
        <div class="module-title">
            <h2>{{ module.title }}</h2>
            <div class="module-actions">
                <md-button class="md-raised show-more-button" @click="display(module.name)">Conteúdo!</md-button>
                <md-button class="md-raised buy-button">€{{ module.price }} | Comprar!</md-button>
            </div>
        </div> 
        <div class="module-content" v-show="displayer == module.name">
            <md-icon class="md-size-4x" :md-src="module.icon"></md-icon>
            <ul v-if="module.listing.length > 0">
                <li v-for="(chapter, index) in module.listing" :key="index">
                    <h3>{{ chapter.title }}</h3>
                    <ul class="content-listing">
                        <li v-for="(item, index) in chapter.content" :key="index">{{ item }}</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'module',
    props: ['module'],
    data() {
        return {
            displayer: ''
        }
    },
    methods: {
        display(section) {
            return this.displayer == '' ? this.displayer = section : this.displayer = ''
        }
    }
}
</script>

<style lang="scss" scoped>

$red: #e53935;
$blue: #2196F3;
$green: #43a047;

.module
{
    border-bottom: 1px solid aliceblue;
    margin-bottom: 20px;

    .module-title
    {
        display: flex;
        flex-direction: column;
        align-items: center;

        @media (max-width: 500px)
        {
            h2 { font-size: 16px; }
        }

        .module-actions
        {
            margin: 10px 0; 

            .buy-button
            {
                background: $blue !important;
                color: white !important;
            }

            .show-more-button
            {
                background: $green !important;
                color: white !important;
            }
        }

    }

    .module-content
    {
        display: flex;
        flex-direction: column;
        margin: 5px 0;
        align-items: center;

        ul
        {
            list-style-type: decimal;
        }

    }

    .content-listing
    {
        margin-top: 10px;
    }

}

</style>

