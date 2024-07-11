<template>
    <a href="#" @click.prevent="copy">{{ value }}</a>
</template>
<script>
export default {
    props: ['value'],
    methods: {
        copy() {
            navigator.clipboard.writeText(this.value)
            this.$toast('Link copiado', null, 'success')
        }
    }
}
</script>