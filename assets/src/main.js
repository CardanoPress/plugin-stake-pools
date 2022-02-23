window.addEventListener('alpine:init', () => {
    const Alpine = window.Alpine || {}
    const cardanoPress = window.cardanoPress || {}

    Alpine.data('cardanoPressStakePools', () => ({
        isProcessing: false,
        transactionHash: '',

        async init() {
            console.log('CardanoPress Stake Pools ready!')
        },

        async handleDelegation(poolId) {
            this.transactionHash = ''

            cardanoPress.api.addNotice({
                id: 'delegation',
                type: 'info',
                text: 'Processing...',
            })

            this.isProcessing = true
            const response = await cardanoPress.wallet.delegationTx(poolId)

            cardanoPress.api.removeNotice('delegation')

            if (response.success) {
                this.transactionHash = response.data

                cardanoPress.api.addNotice({ type: 'info', text: 'Delegation successful' })
            } else {
                cardanoPress.api.addNotice({ type: 'warning', text: response.data })
            }

            this.isProcessing = false
        },
    }))
})
