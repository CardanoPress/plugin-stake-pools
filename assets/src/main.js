window.addEventListener('alpine:init', () => {
    const Alpine = window.Alpine || {}

    Alpine.data('cardanoPressStakePools', () => ({
        async init() {
            console.log('CardanoPress Stake Pools ready!')
        },
    }))
})
