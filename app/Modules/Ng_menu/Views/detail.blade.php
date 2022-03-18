<style>
    .groups{
        cursor: pointer;
        font-weight: bold;
        color: #3c8dbc;
    }

    .disabled{		
        color:rgb(136, 136, 136);
        font-weight: normal;
    }
</style>

<table class="table">
    <tbody>
        <tr>
            <td>Name</td>
            <td width="10px">:</td>
            <td>{{ isset($data->name)? $data->name : '' }}</td>
        </tr>
        <tr>
            <td width="150px">Link</td>
            <td width="10px">:</td>
            <td>{{ isset($data->slug)? $data->slug : '' }}</td>
        </tr>
        <tr>
            <td>Parent</td>
            <td width="10px">:</td>
            <td>{{ isset($data->parents->name)? $data->parents->name : '' }}</td>
        </tr>
        <tr>
            <td>Urutan</td>
            <td width="10px">:</td>
            <td>{{ isset($data->ordering)? $data->ordering : '' }}</td>
        </tr>
        <tr>
            <td>Publish</td>
            <td width="10px">:</td>
            <td>{{ $data->display == 1 ? 'Publish' : 'Draft' }}</td>
        </tr>
        <tr>
            <td>Menu Type</td>
            <td width="10px">:</td>
            <td>{{ isset($data->ng_menu_type->name)? $data->ng_menu_type->name : '' }}</td>
        </tr>
        <tr>
            <td>Component Type</td>
            <td width="10px">:</td>
            @php
                $components = getComponentType();
            @endphp
            <td>{{ array_key_exists($data->component_type,$components)? $components[$data->component_type] : '' }}</td>
        </tr>
        <!-- pcy. component link nya belum -->
        <tr>
            <td>Icon</td>
            <td width="10px">:</td>
            <td>{{ isset($data->icon)? $data->icon : '' }}</td>
        </tr>
    </tbody>
</table>