object FrameChar: TFrameChar
  Left = 0
  Top = 0
  Width = 527
  Height = 436
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object PageControl1: TPageControl
    Left = 0
    Top = 0
    Width = 527
    Height = 436
    ActivePage = TabSheet2
    Align = alClient
    TabOrder = 0
    object TabSheet1: TTabSheet
      Caption = #1069#1082#1080#1087#1080#1088#1086#1074#1082#1072
      ExplicitLeft = 0
      ExplicitTop = 0
      ExplicitWidth = 0
      ExplicitHeight = 0
      object ttWeapon: TLabel
        Left = 110
        Top = 16
        Width = 66
        Height = 21
        Caption = 'Weapon'
      end
      object ttArmor: TLabel
        Left = 110
        Top = 43
        Width = 55
        Height = 21
        Caption = 'Armor'
      end
      object Label2: TLabel
        Left = 16
        Top = 16
        Width = 88
        Height = 21
        Caption = #1042' '#1088#1091#1082#1072#1093':'
      end
      object Label3: TLabel
        Left = 16
        Top = 43
        Width = 88
        Height = 21
        Caption = #1053#1072' '#1090#1077#1083#1077':'
      end
    end
    object TabSheet2: TTabSheet
      Caption = #1048#1085#1074#1077#1085#1090#1072#1088#1100
      ImageIndex = 1
      object SG: TStringGrid
        Left = 0
        Top = 25
        Width = 519
        Height = 311
        Align = alClient
        Color = clBtnFace
        RowCount = 101
        Options = [goFixedVertLine, goFixedHorzLine, goVertLine, goHorzLine, goRowSelect]
        ScrollBars = ssVertical
        TabOrder = 0
        OnClick = SGClick
        OnDblClick = SGDblClick
        ColWidths = (
          64
          64
          64
          64
          64)
      end
      object Panel1: TPanel
        Left = 0
        Top = 0
        Width = 519
        Height = 25
        Align = alTop
        Caption = '0/100'
        TabOrder = 1
      end
      object Panel2: TPanel
        Left = 0
        Top = 336
        Width = 519
        Height = 64
        Align = alBottom
        TabOrder = 2
        object ttInfo: TLabel
          Left = 1
          Top = 1
          Width = 517
          Height = 62
          Align = alClient
          Alignment = taCenter
          AutoSize = False
          WordWrap = True
          ExplicitLeft = 0
          ExplicitTop = 6
        end
      end
    end
    object TabSheet3: TTabSheet
      Caption = #1057#1090#1072#1090#1080#1089#1090#1080#1082#1072
      ImageIndex = 2
      object ttStatKills: TLabel
        Left = 16
        Top = 16
        Width = 121
        Height = 21
        Caption = 'ttStatKills'
      end
      object ttStatDeads: TLabel
        Left = 16
        Top = 43
        Width = 121
        Height = 21
        Caption = 'ttStatDeads'
      end
    end
    object TabSheet4: TTabSheet
      Caption = #1053#1072#1089#1090#1088#1086#1081#1082#1080
      ImageIndex = 3
    end
  end
end
