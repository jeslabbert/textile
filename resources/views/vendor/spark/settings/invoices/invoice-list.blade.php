<spark-invoice-list :user="user" :team="team"
                    :invoices="invoices" :billable-type="billableType" inline-template>

    <div class="card card-default">
        <div class="card-header">{{__('Invoices')}}</div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                </thead>
                <tbody>
                <tr v-for="invoice in invoices">
                    <!-- Invoice Date -->
                    <td style="vertical-align: middle;">
                        <strong>@{{ invoice.created_at | date }}</strong>
                    </td>

                    <!-- Invoice Total -->
                    <td style="vertical-align: middle;">
                        @{{ invoice.total | currency }}
                    </td>

                    <!-- Invoice Download Button -->
                    <td class="text-right">
                        <a :href="downloadUrlFor(invoice)">
                            <button class="btn-sm btn-default">
                                <i class="fa fa-btn fa-file-pdf-o"></i>
                            </button>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</spark-invoice-list>
