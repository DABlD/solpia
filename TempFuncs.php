<!-- GENERATE LOCATION STATISTICS -->
public function tempFunc(){
    $provinces = ["ABRA","AGUSAN DEL NORTE","AGUSAN DEL SUR","AKLAN","ALBAY","ANTIQUE","APAYAO","AURORA","BASILAN","BATAAN","BATANES","BATANGAS","BENGUET","BILIRAN","BOHOL","BUKIDNON","BULACAN","CAGAYAN","CAMARINES NORTE","CAMARINES SUR","CAMIGUIN","CAPIZ","CATANDUANES","CAVITE","CEBU","COTABATO","DAVAO","DINAGAT ISLANDS","EASTERN SAMAR","GUIMARAS","IFUGAO","ILOCOS NORTE","ILOCOS SUR","ILOILO","ISABELA","KALINGA","LA UNION","LAGUNA","LANAO DEL NORTE","LANAO DEL SUR","LEYTE","MAGUINDANAO","MARINDUQUE","MASBATE","MISAMIS OCCIDENTAL","MISAMIS ORIENTAL","MOUNTAIN PROVINCE","NEGROS OCCIDENTAL","NEGROS ORIENTAL","NORTHERN SAMAR","NUEVA ECIJA","NUEVA VIZCAYA","OCCIDENTAL MINDORO","ORIENTAL MINDORO","PALAWAN","PAMPANGA","PANGASINAN","QUEZON","QUIRINO","RIZAL","ROMBLON","SAMAR","SARANGANI","SIQUIJOR","SORSOGON","SOUTH COTABATO","SOUTHERN LEYTE","SULTAN KUDARAT","SULU","SURIGAO DEL NORTE","SURIGAO DEL SUR","TARLAC","TAWI-TAWI","WESTERN SAMAR","ZAMBALES","ZAMBOANGA DEL NORTE","ZAMBOANGA DEL SUR","ZAMBOANGA SIBUGAY"];

    $cities = ["CALOOCAN","LAS PIÑAS","MAKATI","MALABON","MANDALUYONG","MANILA","MARIKINA","MUNTINLUPA","NAVOTAS","PARAÑAQUE","PASAY","PASIG","PATEROS","QUEZON CITY","SAN JUAN","TAGUIG","VALENZUELA"];

    $data = [];
    $data2 = [];

    // foreach($cities as $key => $city){
        // $city = "qc";
    //     if($key == 16){
    //         $data[$city] = User::where('address', 'LIKE', "%" . $city . "%")->where('role', 'Applicant')->pluck('address')->toArray();
    //         dd($city, $data[$city]);
    //     }
    // }

    foreach($provinces as $key => $province){
        $province = "DAVAO";
        if($key == 74){
            $data[$province] = User::where('address', 'LIKE', "%" . $province . "%")->where('role', 'Applicant')->pluck('address')->toArray();
            dd($province, $data[$province]);
        }
    }
}