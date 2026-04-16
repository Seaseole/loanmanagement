<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Regulatory Report') }}
            </h2>
            <x-u-i.button onclick="window.location='{{ route('reports.index') }}'" variant="secondary">
                Back to Reports
            </x-u-i.button>
        </div>
    </x-slot>

    <x-u-i.card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Omang</th>
                        <th class="px-4 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase">Rate</th>
                        <th class="px-4 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase">Disbursed</th>
                        <th class="px-4 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase">Total Repaid</th>
                        <th class="px-4 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($data as $row)
                        <tr class="text-sm">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $row['customer_name'] }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $row['omang'] }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">P{{ number_format($row['loan_amount'], 2) }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">{{ $row['interest_rate'] }}%</td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">{{ $row['disbursement_date'] ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">P{{ number_format($row['total_repaid'], 2) }}</td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 uppercase">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">No data found for the selected period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-u-i.card>
</x-layouts.app>
