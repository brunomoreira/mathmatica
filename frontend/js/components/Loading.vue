<template>
    <div class="loading">
        <div class="wrapper">
            <h1>MATHMATICA</h1>
            <md-progress class="md-warn" md-indeterminate></md-progress>
        </div>
    </div>
</template>

<script>
export default {
  name: 'loading'
}
</script>

<style lang="scss" scoped>

.loading
{
    position: fixed;
    left: 0;
    width: 100%;
    height: 100vh;
    background: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    .wrapper
    {
        width: 80%;
        text-align: center;

        h1
        {
            font-size: 4rem;
            color: #2196F3;

            @media (max-width: 600px)
            {
                font-size: 2.5rem;
            }

        }

        .md-warn
        {
            margin: 30px auto 0 auto;
            width: 57%;

            @media (min-width: 601px)
            {
                width: 419px;
            }

            @media (max-width: 600px)
            {
                width: 259px;
            }

        }
    }

}

.fade-enter-active
{
    transition: opacity 0s
}

.fade-leave-active
{
    transition: opacity .4s
}

.fade-enter, .fade-leave-to
{
    opacity: 0
}

</style>
