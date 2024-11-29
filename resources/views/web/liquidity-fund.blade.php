<x-web.layout id="liquidityfundpage">

    @push('meta')
        <meta name="keywords" content="{{  __("DeFi, investment fund, DeFi fund, mutual fund, non directional, market neutral, Liquidity Fund, USDC, USDT, stablecoin, liquidity mining, yield farming, liquidity pool") }}">
        <meta name="description" content="{{  __("A market neutral investment fund with a target return of 18%. Achieve a stable return through Decentralized Finance.") }}">
    @endpush

    <x-slot:title>
        {{ __("Liquidity Fund | BlockchainTraders") }}
    </x-slot>
    
    <x-slot:heading>
        <div class="heading">
            <h1>BlockchainTraders Liquidity Fund</h1>

            <p class="subtitle">{{ __("Achieve a stable return through Decentralised Finance.") }}</p>
        </div>
    </x-slot>

    <section id="about_the_fund">
        <x-web.afm-banner />

        <h2>{{ __("About the fund") }}</h2>

        <table class="fund_return_figures">
            <tr>
                <th>{{ __("RETURN YTD") }}*</th>
                <th>{{ __("EXPECTED RETURN") }}</th>
                <th>{{ __("HIGHER RETURN THAN TRADITIONAL PORTFOLIO") }}*</th>
            </tr>
            <tr>
                <td>8,52%</td>
                <td>13%</td>
                <td>1,07%</td>
            </tr>
        </table>

        {{-- <div style="position:relative;padding-top:56.25%; margin: 0.5rem 5px 0 0;">
            <iframe src="https://player.vimeo.com/video/656503934?h=18f1c0cf5e&badge=0&autopause=0&player_id=0&app_id=58479" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
        </div> --}}

        <p>{{ __("The BlockchainTraders Liquidity Fund uses Liquidity Mining, also known as Yield Farming to generate returns. Liquidity Miners or Yield Farmers use complex strategies. They constantly move liquidity between different DeFi apps to maximise returns and minimise risk. The fund minimises risks by only providing liquidity in Stable Coins – these have a fixed exchange rate with FIAT currencies like the American dollar – eliminating the risks of exposure to cryptocurrency price changes. Therefore, the fund is market neutral, i.e., generally, not dependent on the market direction as an alternative for a directional investment in cryptocurrencies (like BlockchainTraders Growth Fund offers).") }}</p>

        <iframe src="https://player.vimeo.com/video/656503934?h=18f1c0cf5e&badge=0&autopause=0&player_id=0&app_id=58479" width="100%" height="250px" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>

        {{-- <x:chart-js-fund-chart fund-identifier="1" euro-line-color="#66bd51" :multi-currency=false start-date="2023-01-01"/> --}}

        <p><b>{{ __("Opportunity: taking advantage of a revolution") }}</b></p>

        <ul>
            <li>{!! __("<b>Unique access:</b> with the Liquidity Fund, BlockchainTraders provides an opportunity for investors to take advantage of the revolutionary growth in Decentralised Finance;") !!}</li>
            <li>{!! __("<b>BlockchainTraders</b> has in-depth experience and knowledge of this market and a proven track record in managing cryptocurrencies;") !!}</li>
            <li>{!! __("The <b>strength</b> of the investment strategy lies in the <b>active management</b> of Liquidity Mining positions in order to maximize returns and minimize risks.") !!}</li>
        </ul>

        <p><b>{{ __("Riskmanagement: due diligence and risk mitigation") }}</b></p>

        <p>{{ __("Risk management is crucial in the investment process, which focuses on generating the most stable returns possible and limiting downward movements in the long term. Risks are greatly mitigated by:") }}</p>

        <ul>
            <li>{{ __("Only selecting DeFi applications whose Smart-Contracts have been audited by reputable parties;") }}</li>
            <li>{{ __("Only offer liquidity in Stable Coins: due to the fixed exchange rate with FIAT currencies, such as the US dollar, the risks of being exposed to cryptocurrency price movements are eliminated;") }}</li>
            <li>{{ __("There has to be sufficient liquidity in the DeFi-application and in the Stable Coins;") }}</li>
            <li>{{ __("Continuous monitoring and reallocation of the DeFi-applications.") }}</li>
        </ul>

    </section>

    <section class="fund_info">
        <h3>{{ __("Investment information") }}</h3>
        <hr>
        <table>
            <tbody>
                <tr>
                    <th>{{ __("Fonds inception") }}</th>
                    <td>{{ __("October 18, 2021") }}</td>
                </tr>
                <tr>
                    <th>{{ __("Investment strategy") }}</th>
                    <td>{{ __("Liquidity Mining") }}</td>
                </tr>
                <tr>
                    <th>{{ __("Lead Portfolio manager") }}</th>
                    <td>Justin Kool</td>
                </tr>
                <tr>
                    <th>{{ __("Co-Portfolio manager") }}</th>
                    <td>Michiel van der Steeg</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section class="fund_info">
        <h3>{{ __("Fund information") }}</h3>
        <hr>
        <table>
            <tbody>
                <tr>
                    <th>{{ __("Legal structure") }}</th>
                    <td>{{ __("Mutual Fund") }}</td>
                </tr>
                <tr>
                    <th>{{ __("Fiscal status") }}</th>
                    <td>{{ __("Untaxed") }}</td>
                </tr>
                <tr>
                    <th>{{ __("Transferability") }}</th>
                    <td>{{ __("Non transferable") }}</td>
                </tr>
                <tr>
                    <th>{{ __("Minimum participation") }}</th>
                    <td>€250.000</td>
                </tr>
                <tr>
                    <th>{{ __("Redemption Fee") }}</th>
                    <td>2% ({{ __("first year only") }})</td>
                </tr>
                <tr>
                    <th>{{ __("Withdrawals / Deposits") }}</th>
                    <td>{{ __("Monthly") }}</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section class="fund_info">
        <h3>{{ __("Cost structure") }}</h3>
        <hr>
        <table>
            <tbody>
                <tr>
                    <th>{{ __("Start-up costs") }}</th>
                    <td>{{ __("€1.295 (one-time)**") }}</td>
                </tr>
                <tr>
                    <th>{{ __("Management fee") }}</th>
                    <td>{{ __("0,4% (quarterly)") }}</td>
                </tr>
                <tr>
                    <th>{{ __("Performance fee") }}</th>
                    <td>{{ __("15% (lifelong HWM)") }}<sup>1</sup></td>
                </tr>
                <tr>
                    <th>{{ __("Other costs") }}</th>
                    <td>1% <sup>2</sup></td>
                </tr>
            </tbody>
        </table>
    </section>

    <section class="fund_info">
        <h3>{{ __("Service providers") }}</h3>
        <hr>
        <table>
            <tbody>
                <tr>
                    <th>{{ __("Investment manager") }}</th>
                    <td>BlockchainTraders B.V.</td>
                </tr>
                <tr>
                    <th>{{ __("Judicial owner ") }}</th>
                    <td>Stichting Toezicht<br>BlockchainTraders</td>
                </tr>
                <tr>
                    <th>{{ __("Bank") }}</th>
                    <td>Bunq B.V.</td>
                </tr>
                <tr>
                    <th>{{ __("Custodial solution") }}</th>
                    <td>Fireblocks</td>
                </tr>
                <tr>
                    <th>Corporate Exchange</th>
                    <td>Bitvavo / Flow Traders</td>
                </tr>
                <tr>
                    <th>KYC Software</th>
                    <td>ComplianceWise</td>
                </tr>
                <tr>
                    <th>Wwft Internal Auditor</th>
                    <td>Endymion</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section class="fund_info documentation">
        <h3>{{ __("Fund documentation") }} Liquidity Fund</h3>
        <hr>
        <table>
            <tbody>
                <tr>
                    <th><i class="fa-solid fa-file-lines"></i> {{ __("Essential information document") }}</th>
                    <td onclick="openInformationRequestModal('Liquidity Fund Essential information document')" class="link">{{ __("Request") }} <i class="fa fa-arrow-right fa-fw"></i></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-file-lines"></i> {{ __("Information Memorandum") }}</th>
                    <td onclick="openInformationRequestModal('Liquidity Fund Information Memorandum')" class="link">{{ __("Request") }} <i class="fa fa-arrow-right fa-fw"></i></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-file-lines"></i> {{ __("Performance update") }}</th>
                    <td onclick="openInformationRequestModal('Liquidity Fund Performance update')" class="link">{{ __("Request") }} <i class="fa fa-arrow-right fa-fw"></i></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-file-lines"></i> {{ __("Product Information document") }}</th>
                    <td onclick="openInformationRequestModal('Liquidity Fund Product Information document')" class="link">{{ __("Request") }} <i class="fa fa-arrow-right fa-fw"></i></td>
                </tr>
            </tbody>
        </table>
    </section>

    <section>
        <p class="small">
            * {{ __("Return from December 31, 2023, to August 27, 2024.") }}
            <br>** {{ __("Applicable to the BlockchainTraders Liquidity Fund.") }}
            <br>1 {{ __("High Water Mark (HWM), and no hurdle rate applies.") }}
            <br>2 {{ __("'Other' refers to accounting costs, registration costs at the AFM.") }}
            <br>{{  __("No rights can be derived from the information on this page.") }}
        </p>
    </section>

</x-web.layout>