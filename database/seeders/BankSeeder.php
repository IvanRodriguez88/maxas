<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bancos = [
            ["name" => "BANAMEX", "description" => "Banco Nacional de México, S.A., Institución de Banca Múltiple, Grupo Financiero Banamex"],
            ["name" => "BANCOMEXT", "description" => "Banco Nacional de Comercio Exterior, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo"],
            ["name" => "BANOBRAS", "description" => "Banco Nacional de Obras y Servicios Públicos, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo"],
            ["name" => "BBVA BANCOMER", "description" => "BBVA Bancomer, S.A., Institución de Banca Múltiple, Grupo Financiero BBVA Bancomer"],
            ["name" => "SANTANDER", "description" => "Banco Santander (México), S.A., Institución de Banca Múltiple, Grupo Financiero Santander"],
            ["name" => "BANJERCITO", "description" => "Banco Nacional del Ejército, Fuerza Aérea y Armada, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo"],
            ["name" => "HSBC", "description" => "HSBC México, S.A., institución De Banca Múltiple, Grupo Financiero HSBC"],
            ["name" => "BAJIO", "description" => "Banco del Bajío, S.A., Institución de Banca Múltiple"],
            ["name" => "IXE", "description" => "IXE Banco, S.A., Institución de Banca Múltiple, IXE Grupo Financiero"],
            ["name" => "INBURSA", "description" => "Banco Inbursa, S.A., Institución de Banca Múltiple, Grupo Financiero Inbursa"],
            ["name" => "INTERACCIONES", "description" => "Banco Interacciones, S.A., Institución de Banca Múltiple"],
            ["name" => "MIFEL", "description" => "Banca Mifel, S.A., Institución de Banca Múltiple, Grupo Financiero Mifel"],
            ["name" => "SCOTIABANK", "description" => "Scotiabank Inverlat, S.A."],
            ["name" => "BANREGIO", "description" => "Banco Regional de Monterrey, S.A., Institución de Banca Múltiple, Banregio Grupo Financiero"],
            ["name" => "INVEX", "description" => "Banco Invex, S.A., Institución de Banca Múltiple, Invex Grupo Financiero"],
            ["name" => "BANSI", "description" => "Bansi, S.A., Institución de Banca Múltiple"],
            ["name" => "AFIRME", "description" => "Banca Afirme, S.A., Institución de Banca Múltiple"],
            ["name" => "BANORTE", "description" => "Banco Mercantil del Norte, S.A., Institución de Banca Múltiple, Grupo Financiero Banorte"],
            ["name" => "THE ROYAL BANK", "description" => "The Royal Bank of Scotland México, S.A., Institución de Banca Múltiple"],
            ["name" => "AMERICAN EXPRESS", "description" => "American Express Bank (México), S.A., Institución de Banca Múltiple"],
            ["name" => "BAMSA", "description" => "Bank of America México, S.A., Institución de Banca Múltiple, Grupo Financiero Bank of America"],
            ["name" => "TOKYO", "description" => "Bank of Tokyo-Mitsubishi UFJ (México), S.A."],
            ["name" => "JP MORGAN", "description" => "Banco J.P. Morgan, S.A., Institución de Banca Múltiple, J.P. Morgan Grupo Financiero"],
            ["name" => "BMONEX", "description" => "Banco Monex, S.A., Institución de Banca Múltiple"],
            ["name" => "VE POR MAS", "description" => "Banco Ve Por Mas, S.A. Institución de Banca Múltiple"],
            ["name" => "ING", "description" => "ING Bank (México), S.A., Institución de Banca Múltiple, ING Grupo Financiero"],
            ["name" => "DEUTSCHE", "description" => "Deutsche Bank México, S.A., Institución de Banca Múltiple"],
            ["name" => "CREDIT SUISSE", "description" => "Banco Credit Suisse (México), S.A. Institución de Banca Múltiple, Grupo Financiero Credit Suisse (México)"],
            ["name" => "AZTECA", "description" => "Banco Azteca, S.A. Institución de Banca Múltiple"],
            ["name" => "AUTOFIN", "description" => "Banco Autofin México, S.A. Institución de Banca Múltiple"],
            ["name" => "BARCLAYS", "description" => "Barclays Bank México, S.A., Institución de Banca Múltiple, Grupo Financiero Barclays México"],
            ["name" => "COMPARTAMOS", "description" => "Banco Compartamos, S.A., Institución de Banca Múltiple"],
            ["name" => "BANCO FAMSA", "description" => "Banco Ahorro Famsa, S.A., Institución de Banca Múltiple"],
            ["name" => "BMULTIVA", "description" => "Banco Multiva, S.A., Institución de Banca Múltiple, Multivalores Grupo Financiero"],
            ["name" => "ACTINVER", "description" => "Banco Actinver, S.A. Institución de Banca Múltiple, Grupo Financiero Actinver"],
            ["name" => "WAL-MART", "description" => "Banco Wal-Mart de México Adelante, S.A., Institución de Banca Múltiple"],
            ["name" => "NAFIN", "description" => "Nacional Financiera, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo"],
            ["name" => "INTERBANCO", "description" => "Inter Banco, S.A. Institución de Banca Múltiple"],
            ["name" => "BANCOPPEL", "description" => "BanCoppel, S.A., Institución de Banca Múltiple"],
            ["name" => "ABC CAPITAL", "description" => "ABC Capital, S.A., Institución de Banca Múltiple"],
            ["name" => "UBS BANK", "description" => "UBS Bank México, S.A., Institución de Banca Múltiple, UBS Grupo Financiero"],
            ["name" => "CONSUBANCO", "description" => "Consubanco, S.A. Institución de Banca Múltiple"],
            ["name" => "VOLKSWAGEN", "description" => "Volkswagen Bank, S.A., Institución de Banca Múltiple"],
            ["name" => "CIBANCO", "description" => "CIBanco, S.A."],
            ["name" => "BBASE", "description" => "Banco Base, S.A., Institución de Banca Múltiple"],
            ["name" => "BANSEFI", "description" => "Banco del Ahorro Nacional y Servicios Financieros, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo"],
            ["name" => "HIPOTECARIA FEDERAL", "description" => "Sociedad Hipotecaria Federal, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo"],
            ["name" => "MONEXCB", "description" => "Monex Casa de Bolsa, S.A. de C.V. Monex Grupo Financiero"],
            ["name" => "GBM", "description" => "GBM Grupo Bursátil Mexicano, S.A. de C.V. Casa de Bolsa"],
            ["name" => "MASARI", "description" => "Masari Casa de Bolsa, S.A."],
            ["name" => "VALUE", "description" => "Value, S.A. de C.V. Casa de Bolsa"],
            ["name" => "ESTRUCTURADORES", "description" => "Estructuradores del Mercado de Valores Casa de Bolsa, S.A. de C.V."],
            ["name" => "TIBER", "description" => "Casa de Cambio Tiber, S.A. de C.V."],
            ["name" => "VECTOR", "description" => "Vector Casa de Bolsa, S.A. de C.V."],
            ["name" => "B&B", "description" => "B y B, Casa de Cambio, S.A. de C.V."],
            ["name" => "ACCIVAL", "description" => "Acciones y Valores Banamex, S.A. de C.V., Casa de Bolsa"],
            ["name" => "MERRILL LYNCH", "description" => "Merrill Lynch México, S.A. de C.V. Casa de Bolsa"],
            ["name" => "FINAMEX", "description" => "Casa de Bolsa Finamex, S.A. de C.V."],
            ["name" => "VALMEX", "description" => "Valores Mexicanos Casa de Bolsa, S.A. de C.V."],
            ["name" => "UNICA", "description" => "Unica Casa de Cambio, S.A. de C.V."],
            ["name" => "MAPFRE", "description" => "MAPFRE Tepeyac, S.A."],
            ["name" => "PROFUTURO", "description" => "Profuturo G.N.P., S.A. de C.V., Afore"],
            ["name" => "CB ACTINVER", "description" => "Actinver Casa de Bolsa, S.A. de C.V."],
            ["name" => "OACTIN", "description" => "OPERADORA ACTINVER, S.A. DE C.V."],
            ["name" => "SKANDIA", "description" => "Skandia Vida, S.A. de C.V."],
            ["name" => "CBDEUTSCHE", "description" => "Deutsche Securities, S.A. de C.V. CASA DE BOLSA"],
            ["name" => "ZURICH", "description" => "Zurich Compañía de Seguros, S.A."],
            ["name" => "ZURICHVI", "description" => "Zurich Vida, Compañía de Seguros, S.A."],
            ["name" => "SU CASITA", "description" => "Hipotecaria Su Casita, S.A. de C.V. SOFOM ENR"],
            ["name" => "CB INTERCAM", "description" => "Intercam Casa de Bolsa, S.A. de C.V."],
            ["name" => "CI BOLSA", "description" => "CI Casa de Bolsa, S.A. de C.V."],
            ["name" => "BULLTICK CB", "description" => "Bulltick Casa de Bolsa, S.A., de C.V."],
            ["name" => "STERLING", "description" => "Sterling Casa de Cambio, S.A. de C.V."],
            ["name" => "FINCOMUN", "description" => "Fincomún, Servicios Financieros Comunitarios, S.A. de C.V."],
            ["name" => "HDI SEGUROS", "description" => "HDI Seguros, S.A. de C.V."],
            ["name" => "ORDER", "description" => "Order Express Casa de Cambio, S.A. de C.V"],
            ["name" => "AKALA", "description" => "Akala, S.A. de C.V., Sociedad Financiera Popular"],
            ["name" => "CB JPMORGAN", "description" => "J.P. Morgan Casa de Bolsa, S.A. de C.V. J.P. Morgan Grupo Financiero"],
            ["name" => "REFORMA", "description" => "Operadora de Recursos Reforma, S.A. de C.V., S.F.P."],
            ["name" => "STP", "description" => "Sistema de Transferencias y Pagos STP, S.A. de C.V.SOFOM ENR"],
            ["name" => "TELECOMM", "description" => "Telecomunicaciones de México"],
            ["name" => "EVERCORE", "description" => "Evercore Casa de Bolsa, S.A. de C.V."],
            ["name" => "SKANDIA", "description" => "Skandia Operadora de Fondos, S.A. de C.V."],
            ["name" => "SEGMTY", "description" => "Seguros Monterrey New York Life, S.A de C.V"],
            ["name" => "ASEA", "description" => "Solución Asea, S.A. de C.V., Sociedad Financiera Popular"],
            ["name" => "KUSPIT", "description" => "Kuspit Casa de Bolsa, S.A. de C.V."],
            ["name" => "SOFIEXPRESS", "description" => "J.P. SOFIEXPRESS, S.A. de C.V., S.F.P."],
            ["name" => "UNAGRA", "description" => "UNAGRA, S.A. de C.V., S.F.P."],
            ["name" => "OPCIONES EMPRESARIALES DEL NOROESTE", "description" => "OPCIONES EMPRESARIALES DEL NORESTE, S.A. DE C.V., S.F.P."],
            ["name" => "CLS", "description" => "Cls Bank International"],
            ["name" => "INDEVAL", "description" => "Indeval, S.A. de C.V."],
            ["name" => "LIBERTAD", "description" => "Libertad Servicios Financieros, S.A. De C.V."]
        ];

        foreach ($bancos as $banco) {
            Bank::create([
                "name" => $banco['name'],
                "description" => $banco['description']
            ]);
        }
    }
}
