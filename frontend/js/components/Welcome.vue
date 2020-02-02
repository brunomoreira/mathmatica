<template>
  <div class="hello wrapper">
    <md-layout class="course-options" md-row>
      <md-layout class="box" md-flex-xsmall="100" md-flex-small="50" md-align="center">
        <md-button class="btn md-raised md-primary">Ensino Básico</md-button>
      </md-layout>
      <md-layout class="box" md-flex-xsmall="100" md-flex-small="50" md-align="center">
        <md-button class="btn md-raised md-primary">Ensino Secundário</md-button>
      </md-layout> 
    </md-layout>
  </div>
</template>

<script>
export default {
  name: 'welcome'
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

.wrapper
{
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;

  .course-options
  {
    align-items: center;
    justify-content: space-between;
    width: 100%;

   .box
    {
      padding: 0 20px;

      .btn
      {
        width: 100%;
        height: 125px;
        font-size: 1.3rem;
        background: #2196F3;
        transition: all 300ms ease-in-out;
        border: 5px solid #2196f3;
        &:hover { background: white; color: #2196F3; border: 5px solid #2196F3; }
      }

    }

    @media (max-width: 769px)
    {
      flex: none;
    }

  }

  @media (max-width: 769px)
  {
    justify-content: center;
  }

}

</style>
