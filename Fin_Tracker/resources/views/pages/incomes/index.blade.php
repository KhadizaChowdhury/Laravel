@extends('layouts.dashboard')
@section('dasboard-body-content')
<div class="container mx-auto">
    <div class="flex flex-col">
        <div class="w-full">
            <div class="p-8 border-b border-gray-200 shadow">
                <table class="divide-y divide-gray-300" id="tableData">
                    <thead class="bg-black">
                        <tr>
                            <th class="px-6 py-2 text-xs text-white">
                                ID
                            </th>
                            <th class="px-6 py-2 text-xs text-white">
                                Description
                            </th>
                            <th class="px-6 py-2 text-xs text-white">
                                Amount
                            </th>
                            <th class="px-6 py-2 text-xs text-white">
                                Category
                            </th>
                            <th class="px-6 py-2 text-xs text-white">
                                Date
                            </th>
                            <th class="px-6 py-2 text-xs text-white">
                                Edit
                            </th>
                            <th class="px-6 py-2 text-xs text-white">
                                Delete
                            </th>
                        </tr>
                    </thead>
                    <tbody id="allIncome" class="bg-white divide-y divide-gray-300">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    window.onload = function()
    {

    Incomes();
    async function Incomes() {
        let URL = "/allIncome";
        try {
          const response = await axios.get(URL);
            const incomes = response.data;
            console.log(incomes);

            let tableData = $('#tableData');
            let allIncome = $('#allIncome');

            tableData.DataTable().destroy();
            allIncome.empty();

            // Iterate over the incomes and create HTML elements for each income
            incomes.forEach(function(income,index){
              let row =
                `<tr class="text-center whitespace-nowrap">
                    <td class="px-6 py-4 text-sm text-gray-500">
                        ${index+1}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                          ${income['description']}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">${income['amount']}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">${income['category']}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">${income['date']}</div>
                    </td>
                    <td class="px-6 py-4">
                        <a class="inline-block text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <a class="inline-block text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </a>
                    </td>
                </tr>`
                allIncome.append(row)
            });
            tableData.DataTable({
              order: [[5, 'desc']],
              lengthMenu: [3,5,10,15,20]
            })

        } catch (error) {
            console.error(error);
            // Handle the error, e.g., display an error message
        }
    }

    

    }

</script>