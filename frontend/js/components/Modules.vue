<template>
    <div class="modules-container">
        <module v-for="(module, index) in modules" :key="index" :module="module"></module>
        <div class="buy-all-modules">
            <div class="title">
                <h1>Premium</h1>
            </div>
            <md-button class="md-raised md-warn">€20 | Premium (20% de Desconto)</md-button>
            <md-button class="md-raised md-primary" @click="openPremiumFAQ()">Saber Mais!</md-button>
        </div>
        <md-layout class="premium-faq" v-show="displayPremiumFAQ">
            <h2>Porquê Premium?</h2>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iure maxime dolorum, suscipit soluta voluptatem aperiam perspiciatis voluptates praesentium tempora eum similique exercitationem architecto, animi quae? Eveniet provident reiciendis distinctio nisi!</p>
            <p>Iure molestiae libero rem illum laboriosam nostrum vero porro dolorem vel fugiat fugit, eum iste consequuntur aliquam. Cupiditate doloribus possimus veritatis modi et facere nihil nostrum aspernatur, nemo eos maiores.</p>
            <p>Repellendus inventore ut at, harum dolor amet saepe provident sed corporis? Ipsa hic incidunt earum odit quos provident quis libero, veritatis voluptas commodi illum, recusandae ab dolorum architecto distinctio. Obcaecati?</p>
        </md-layout>
    </div>
</template>

<script>

import Module from './Module'

export default {
    name: 'modules',
    props: ['user'],
    components: { Module },
    data() {
        return {
            displayPremiumFAQ: false,
            modules: [
                {
                    title: '1. Probabilidades', 
                    listing: [
                        { title: 'Análise Combinatória. Triângulo de Pascal. Binómio de Newton.', content: ['Princípios fundamentais da contagem', 'Fatorial de um número natural', 'Arranjos', 'Combinações', 'Triângulo de Pascal', 'Binómio de Newton'] },
                        { title: 'Cálculo de Probabilidades. Regra de Laplace.', content: ['Experiência aleatória. Espaço de resultados', 'Acontecimentos', 'Acontecimentos complementares ou acontecimentos contrários', 'Acontecimentos disjuntos, incompatíveis ou mutuamente exclusivos', 'Definição frequencista de probabilidade', 'Definição clássica de probabilidade ou Regra de Laplace'] },
                        { title: 'Axiomas e teoremas de probabilidade. Probabilidade condicionada. Acontecimentos Independentes.', content: ['Operações com conjuntos', 'Propriedades das operações com conjuntos', 'Leis de Morgan', 'Axiomas de probabilidades', 'Alguns teoremas sobre probabilidades', 'Probabilidades condicionada', 'Acontecimentos Independentes'] },
                    ],
                    price: 5,
                    name: 'probability',
                    icon: '/dist/img/icons/probability.svg'
                },
                {
                    title: '2. Estatística', 
                    listing: [
                        { title: 'Estatística. Distribuição de probabilidades.', content: ['Estatística', 'Distribuição de probabilidades de uma variável aleatória.'] },
                    ],
                    price: 2,
                    name: 'statistics',
                    icon: '/dist/img/icons/statistics.svg'
                },
                {
                    title: '3. Funções', 
                    listing: [
                        { title: 'Definições. Diferentes tipos de funções. Operações com funções. Sucessões.', content: ['Definições', 'Transformações e simetrias do gráfico de um função', 'Diferentes tipos de funções', 'Operações com funções', 'Composição de funções', 'Função Inversa', 'Definição de sucessão', 'Progressão Aritmética', 'Progressão Geométrica', 'Classificação de uma sucessão quanto à convergência', 'Soma dos termos de um progressão geométrica', 'Número de Neper'] },
                        { title: 'Função Exponencial e Função Logarítmica', content: ['Função exponencial', 'Logaritmos', 'Função logarítmica'] },
                        { title: 'Limites e Continuidade', content: ['Noção intuitiva de limite', 'Definição de limite segundo Heine', 'Limites laterais', 'Propriedades dos limites', 'Cálculo de limites. Indeterminações', 'Limites de funções envolvendo exponenciais e logaritmos', 'Continuidade de um função num ponto', 'Assíntotas do gráfico de um função'] },
                        { title: 'Derivadas', content: ['Definições e conceitos iniciais', 'Derivabilidade e continuidade', 'Função derivada', 'Regras de derivação', 'Aplicações da derivada de uma função', 'Aplicações da segunda derivada de um função', 'Estudo de funções', 'Problemas de optimização'] }
                    ],
                    price: 5,
                    name: 'functions',
                    icon: '/dist/img/icons/functions.svg'
                },
                {
                    title: '4. Trigonometria', 
                    listing: [
                        { title: 'Trigonometria', content: ['Radiano', 'Funções Trigonométricas', 'Valores em pi/6, pi/4 e pi/3', 'Equações trigonométricas', 'Fórmulas trigonométricas', 'Resolução de problemas usando funções trigonométricas', 'As funções trigonométricas como modelos de fenómenos reais', 'Limites de funções trigonométricas', 'Derivadas de funções trigonométricas'] },
                        { title: 'Função Exponencial e Função Logarítmica', content: ['Função exponencial', 'Logaritmos', 'Função logarítmica'] },
                        { title: 'Limites e Continuidade', content: ['Noção intuitiva de limite', 'Definição de limite segundo Heine', 'Limites laterais', 'Propriedades dos limites', 'Cálculo de limites. Indeterminações', 'Limites de funções envolvendo exponenciais e logaritmos', 'Continuidade de um função num ponto', 'Assíntotas do gráfico de um função'] },
                        { title: 'Derivadas', content: ['Definições e conceitos iniciais', 'Derivabilidade e continuidade', 'Função derivada', 'Regras de derivação', 'Aplicações da derivada de uma função', 'Aplicações da segunda derivada de um função', 'Estudo de funções', 'Problemas de optimização'] }
                    ],
                    price: 5,
                    name: 'trigonometry',
                    icon: '/dist/img/icons/trigonometry.svg'
                },
                {
                    title: '5. Números Complexos', 
                    listing: [
                        { title: 'Números Complexos', content: ['Definições', 'Representação geométrica de um número complexo', 'Operações com números complexos', 'Representação trigonométrica de um número complexo. Operações com complexos na forma trigonométrica', 'Domínios planos e condições em variável complexa'] },
                    ],
                    price: 3,
                    name: 'complex',
                    icon: '/dist/img/icons/complex.svg'
                },
                {
                    title: '6. Geometria', 
                    listing: [
                        { title: 'Geometria', content: ['Distância entre dois pontos. Lugares Geométricos no plano e no espaço', 'Vetores livres no plano e no espaço', 'Vetores referenciais cartesianos do plano e no espaço', 'Produto escalar de dois vetores', 'Retas no plano e no espaço', 'Conjuntos de pontos definidos por condições no plano e no espaço', 'Equação cartesiana de um plano', 'Posição relativa de retas e planos', 'Interseção de planos', 'Programação Linear'] }
                    ],
                    price: 5,
                    name: 'geometry',
                    icon: '/dist/img/icons/geometry.svg'
                }
            ]
        }
    },
    methods: {
        openPremiumFAQ() {
            return this.displayPremiumFAQ = !this.displayPremiumFAQ
        }
    }
}
</script>

<style lang="scss" scoped>

$red: #e53935;
$blue: #2196F3;
$green: #43a047;

.modules-container
{
    width: 100%;

    .buy-all-modules
    {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        flex-direction: column;
        margin-top: -20px;

        .title
        {
            width: 100%;
            background: $blue;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;

            h1 { color: white; }
        }

        button
        {
            width: 85%;
        }

    }

    .premium-faq
    {
        padding: 0 20px 20px 20px;
    }

}

</style>


